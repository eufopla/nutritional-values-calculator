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

    


}
