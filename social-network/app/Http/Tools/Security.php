<?php


namespace App\Http\Tools;


use App\Http\Models\Application\Schema;
use DateTime;
use DateTimeZone;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\JWT;
Use Firebase\JWT\Key;
use Illuminate\Contracts\Encryption\DecryptException as DecryptException;
use Illuminate\Contracts\Encryption\EncryptException as EncryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Termwind\Components\Ol;
use UnexpectedValueException;

class Security
{

    private static string $_alg = 'HS256';
    private static string $cypherAlgo = 'aes128';
    private static string $formKey;
    private static string $formIV;

    /**
     * Initializes the encryption keys and IV for forms if they are not already set.
     *
     * @return void
     */
    public static function initKeys(): void
    {
        if (empty(self::$formKey) || empty(self::$formIV)){
            self::$formKey = config('appConfig.form_key');
            self::$formIV = config('appConfig.form_iv');
        }
    }

    /**
     * Encrypts a given value using Laravel's Crypt facade.
     *
     * @param mixed $value The value to be encrypted
     * @return string The encrypted value or an empty string in case of error
     * @throws EncryptException If an error occurs during encryption
     */
    public static function crypt(mixed $value): string
    {
        try {
            return Crypt::encrypt($value);
        } catch (EncryptException $e) {
            Log::error('Error encrypting value: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Encrypts a list of values and returns them as a comma-separated string.
     *
     * @param array $list The list of values to be encrypted
     */
    public static function cryptList(array $list): string
    {
        try {
            $encryptedList = [];

            foreach ($list as $item) {
                $encryptedValue = self::crypt($item);
                $encryptedList[] = '"' . $encryptedValue . '"';
            }

            return implode(',', $encryptedList);
        } catch (Exception $e) {
            Log::error('Error encrypting list: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Decrypts a given encrypted value.
     *
     * @param mixed $value The value to be decrypted
     * @return int|string The decrypted value, or an empty string if decryption fails
     */
    public static function decrypt(mixed $value): int|string {
        try {
            return Crypt::decrypt($value);
        } catch (DecryptException $e) {
            Log::error('Error decrypting value: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Checks if a given value can be successfully decrypted.
     *
     * @param mixed $value The value to be decrypted
     * @return bool True if the decryption is successful, false otherwise
     */
    public static function checkCrypt(mixed $value): bool
    {
        try {
            $result = Crypt::decrypt($value);
            if (!$result) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            Log::error('Error checking crypt: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Encrypts a given value using a predefined encryption algorithm, key, and initialization vector.
     *
     * @param mixed $value The value to be encrypted
     * @return string The encrypted string, or an empty string in case of an error
     * @throws Exception If there is an error during encryption
     */
    public static function cryptForm(mixed $value): string {
        try {
            self::initKeys();
            return openssl_encrypt(
                $value,
                self::$cypherAlgo,
                self::$formKey,
                0,
                self::$formIV
            );
        } catch(\Exception $e) {
            Log::error('Error encrypting form: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Decrypts the provided form value using the specified cipher algorithm, key, and IV.
     *
     * @param string $value The encrypted form value to be decrypted
     * @return int|string The decrypted value, or an empty string if decryption fails
     */
    public static function decryptForm(mixed $value): int|string
    {
        try {
            self::initKeys();
            return openssl_decrypt(
                $value,
                self::$cypherAlgo,
                self::$formKey,
                0,
                self::$formIV
            );
        } catch (\Exception $e) {
            Log::error('Error decrypting form: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Hashes a given password using a secure hashing algorithm.
     *
     * @param string $value The plain text password to be hashed
     * @return string The hashed password
     */
    public static function HashPassword(string $value) : string
    {
        return Hash::make($value);
    }

    /**
     * Verifies if the provided value matches the given password hash.
     *
     * @param string $value The plain text value to validate
     * @param string $passwordHash The hashed password to compare against
     * @return bool True if the hash matches the value, false otherwise
     */
    public static function CheckHash(string $value, string $passwordHash) : bool
    {
        return Hash::check($value, $passwordHash);
    }

    /**
     * Verifies if the provided encrypted value can be successfully decrypted.
     *
     * @param mixed $value The encrypted value to be checked
     * @return bool True if the value can be decrypted; otherwise, false
     */
    public static function checkCryptForm(mixed $value): bool
    {
        try {
            self::initKeys();
            $result = openssl_decrypt(
                $value,
                self::$cypherAlgo,
                self::$formKey,
                0,
                self::$formIV
            );

            if (!$result) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            Log::error('Error checking crypt form: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Decrypts a list of encrypted form data and converts numeric values to integers.
     *
     * @param array $array The array of encrypted form items to be decrypted.
     * @return array The array of decrypted values, where numeric values are cast to integers.
     */
    public static function decryptFormList(array $array) : array
    {

        try {
            $return = [];

            foreach ($array as $item) {
                if (self::checkCryptForm($item) === true) {
                    $decrypted = self::decryptForm($item);
                    if (is_numeric($decrypted)) {
                        $return[] = (int)$decrypted;
                    }
                }
            }
            return $return;
        } catch (Exception $e) {
            Log::error('Error decrypting form list: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Encrypts each item in the provided array and formats it into a JSON string list.
     *
     * @param array $array The array of items to be encrypted
     * @return string A JSON-formatted string of encrypted items
     * @throws Exception
     */
    public static function cryptFormList(array $array) : string
    {

        try {
            $encryptedList = [];

            foreach ($array as $item) {
                $encryptedValue = self::cryptForm($item);
                $encryptedList[] = '{"id": "' . $encryptedValue . '"}';
            }

            return implode(',', $encryptedList);
        } catch (Exception $e) {
            Log::error('Error encrypting form list: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Decrypts a list of items.
     *
     * @param array $array The array of items to decrypt.
     * @return array The decrypted items.
     */
    public static function decryptList(array $array) : array
    {

        try {
            $return = [];

            foreach ($array as $item) {
                if (self::checkCrypt($item)) {
                    $return[] = self::decrypt($item);
                }
            }
            return $return;
        } catch (Exception $e) {
            Log::error('Error decrypting list: ' . $e->getMessage());
            return [];
        }
    }

    public static function checkListDecryptForm($array) : array {

        $return = [];

        foreach ($array as $item){
            if(self::checkCryptForm($item)){
                $return[] = self::decryptForm($item);
            }
        }
        return $return;
    }

    /** JWT */

    public static function generateJWT(int $idUser, string $token, string $appKey): string{

        $key = config('appConfig.jwt_secret');

        $date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))+21600);

        $payload = array(
            "iss"   => config('appConfig.app_url_front'),
            "sub"   => $idUser,
            "data"  => [
                'tokenAppli' => $appKey,
                'tokenUser' => $token,
            ],
            "iat"   => time(),
            "exp"   => time() + (60*60)*6
        );

        return Security::crypt(JWT::encode($payload, $key, self::$_alg));
    }

    public static function decryptJWT($value): object|null {

        $key = config('appConfig.jwt_secret');

        try {

            return JWT::decode(self::decrypt($value), new key ($key,self::$_alg));

        } catch (ExpiredException | SignatureInvalidException | UnexpectedValueException $e) {

            return null;

        }

    }

    /**
     * Generates a one-time token and stores it in the database.
     *
     * @param int $nbMinutes The number of minutes the token should be valid for
     * @return string The generated JWT token
     * @throws Exception If there is an error during token generation or database insertion
     */
    public static function generateOneTimeToken(int $nbMinutes): string
    {
        try {
            $secretKey = config('appConfig.jwt_secret');
            $timeZone = new DateTimeZone('UTC');

            $token = base64_encode(random_bytes(32));
            $issuedAt = time();
            $notBefore = $issuedAt;
            $expire = $notBefore + ($nbMinutes * 60);

            $data = [
                'iat' => $issuedAt,
                'jti' => $token,
                'nbf' => $notBefore,
                'exp' => $expire,
            ];

            $jwt = Security::crypt(JWT::encode($data, $secretKey, self::$_alg));

            $arrayAdd = [
                'token' => $jwt,
                'created_at' => (new DateTime('@' . $issuedAt, $timeZone))->format('Y-m-d H:i:s'),
                'expires_at' => (new DateTime('@' . $expire, $timeZone))->format('Y-m-d H:i:s'),
            ];

            DB::table('one_time_tokens')->insert($arrayAdd);
            return $jwt;

        } catch (Exception $e) {
            Log::error('Error generating one-time token: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Deletes expired One Time Tokens from the database.
     *
     * @return array HTTP status code
     */
    /**
     * Deletes expired one-time tokens from the database.
     *
     * @return array An array containing the HTTP response code
     */
    public static function deleteExpiredToken(): array
    {
        $now = (new DateTime())->format('Y-m-d H:i:s');
        $response = [];

        try {
            $deleted = DB::connection(Schema::CONNECTION_SHARED)
                ->table(Schema::SHARED_SCOPETENZA.'one_time_tokens')
                ->where('expires_at', '<', $now)
                ->delete();

            if ($deleted > 0) {
                $response['code'] = 200;
                $response['message'] = __('messages.delete_success');
            } else {
                $response['code'] = 500;
                $response['message'] = __('messages.delete_error');
            }
        } catch (Exception $e) {
            Log::error('Error deleting expired tokens: ' . $e->getMessage());
            $response['code'] = 400;
            $response['message'] = __('messages.delete_error');
        }

        return $response;
    }

    /**
    /**
     * Validates a one-time token by comparing it with the token stored in the database.
     *
     * @param string $tokenFromUrl The token extracted from the URL
     * @return bool Whether the token is valid or not
     * @throws Exception If there is an error during validation
     */
    public static function validateOneTimeToken(string $tokenFromUrl) : bool
    {

        $tokenFromUrl = filter_var(
            $tokenFromUrl,
            FILTER_UNSAFE_RAW,
            FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH
        );

        $record = DB::table('one_time_tokens')->where('token', $tokenFromUrl)->first();

        if ($record) {
            try {
                $algo = self::$_alg;
                $key = config('appConfig.jwt_secret');
                $timeZone = new DateTimeZone('UTC');
                $now = new DateTime('now', $timeZone);

                $tokenDataFromUrl = JWT::decode(self::decrypt($tokenFromUrl), new Key($key, $algo));
                $tokenDataFromDatabase = JWT::decode(self::decrypt($record->token), new Key($key, $algo));

                $exp = new DateTime('@' . $tokenDataFromDatabase->exp, $timeZone);

                if ($exp <= $now) {
                    return false;
                }

                return $tokenDataFromUrl->iat === $tokenDataFromDatabase->iat &&
                    $tokenDataFromUrl->jti === $tokenDataFromDatabase->jti &&
                    $tokenDataFromUrl->nbf === $tokenDataFromDatabase->nbf &&
                    $tokenDataFromUrl->exp === $tokenDataFromDatabase->exp;

            } catch (\UnexpectedValueException $e) {
                Log::error('Token decoding error: ' . $e->getMessage());
                throw $e;
            } catch (\Exception $e) {
                Log::error('Token validation error: ' . $e->getMessage());
                throw $e;
            }
        }

        return false;
    }

    /**
     * Deletes a used one-time token from the database.
     *
     * @param string $tokenFromUrl The token to be deleted
     * @return array The HTTP response with the result of the deletion
     */
    public static function deleteUsedToken(string $tokenFromUrl) : array
    {
        try {
            $deleted = DB::connection(Schema::CONNECTION_SHARED)
                ->table(Schema::SHARED_SCOPETENZA.'one_time_tokens')
                ->where('token', $tokenFromUrl)
                ->delete();

            if ($deleted > 0) {
                $code = 200;
                $message = __('messages.delete_success');
            } else {
                $code = 500;
                $message = __('messages.delete_error');
            }
        } catch (Exception $e) {
            Log::error('Error deleting token: ' . $e->getMessage());
            $code = 400;
            $message = __('messages.delete_error');
        }

        return ToolsBox::httpResponse($code, $message);
    }

    /**
     * Crypt a job offer ID
     *
     * @param string $id The job offer ID to be encrypted
     * @return string The encrypted job offer ID
     */
    public static function cryptJobOffer(string $id): string
    {
        $id = (int) $id;
        $publicIdentifier = dechex($id * 15).'-CJS';

        $insertPublicIdentifier = DB::connection(Schema::CONNECTION_SPECIFIC)
            ->table(Schema::SPECIFIC_PORTAL.'company_job_offer')
            ->where('id', '=', $id)
            ->update(['publicIdentifier' => $publicIdentifier]);

        if($insertPublicIdentifier >= 0){
            return $publicIdentifier;
        } else {
            return '';
        }
    }

    /**
     * Decrypts the job offer ID from the given crypt string.
     *
     * @param string $idJobOfferCrypt The crypt string representing the job offer ID.
     * @return string The decrypted job offer ID.
     */
    public static function decryptJobOffer(string $idJobOfferCrypt): string
    {
        $idJobOfferCrypt = str_replace('-CJS', '', $idJobOfferCrypt);
        return (int)hexdec($idJobOfferCrypt) / 15 ;
    }

    /**
     * Decyphers a Python-generated ID.
     *
     * @param string $id The encoded ID string to be decyphered.
     * @return int The decrypted ID as an integer.
     */
    public static function decypherPythonId(string $id): int
    {
        $key = config('appConfig.python_key');
        $iv = config('appConfig.python_iv');

        $id = str_replace(' ', '+', $id);

        try {
            $decoded = base64_decode($id);
            $decrypted = openssl_decrypt(
                $decoded,
                'aes-256-cbc',
                $key,
                OPENSSL_RAW_DATA,
                $iv
            );
            return (int)$decrypted;
        } catch (Exception $e) {
            Log::info('Error decyphering ID for Python: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Encrypts an ID to be used by the Python application.
     *
     * @param int|string $id The ID to encrypt.
     * @return string The encrypted ID, base64-encoded.
     */
    public static function cypherForPython(int|string $id): string
    {
        $key = base64_decode(config('appConfig.python_key'));
        $iv = base64_decode(config('appConfig.python_iv'));

        try {

            $encrypted = openssl_encrypt(
                (string)$id,
                'aes-256-cbc',
                $key,
                OPENSSL_RAW_DATA,
                $iv
            );

            return base64_encode($encrypted);

        } catch (\Exception $e) {
            Log::error('Error cyphering ID for Python: ' . $e->getMessage());
            return 'Error cyphering ID for Python: ' . $e->getMessage();
        }
    }

    /**
     * Checks if a given encrypted string can be successfully decrypted using the Python key and IV.
     *
     * @param string $cipher The encrypted ID string to check.
     * @return bool True if decryption is successful, false otherwise.
     */
    public static function checkCypherFromPython(string $cipher): bool
    {
        $key = config('appConfig.python_key');
        $iv = config('appConfig.python_iv');
        $cipher = str_replace(' ', '+', $cipher);

        try {
            $decoded = base64_decode($cipher);
            $decrypted = openssl_decrypt(
                $decoded,
                'aes-256-cbc',
                $key,
                OPENSSL_RAW_DATA,
                $iv
            );
            $isNumeric = $decrypted !== false && is_numeric($decrypted);
            return $isNumeric;
        } catch (\Exception $e) {
            Log::error('Erreur lors du déchiffrement du cipher depuis Python', ['exception' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Generates an external ID by encoding the given ID using a secret key.
     *
     * @param string $id The ID to encode.
     * @return string The encoded external ID.
     */
    public static function makeExternalId(string $id): string
    {
        $secret = config('appConfig.jwt_secret');
        $raw = hash_hmac('sha256', $id, $secret, true);
        return rtrim(strtr(base64_encode($raw), '+/', '-_'), '=');
    }
}
