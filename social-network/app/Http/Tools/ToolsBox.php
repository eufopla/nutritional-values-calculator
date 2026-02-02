<?php


namespace App\Http\Tools;


use App\Http\Models\Application\Schema;
use Countable;
use DateTime;
use DateTimeZone;
use DateInterval;
use Exception;
use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use JetBrains\PhpStorm\Pure;
use \stdClass;


class ToolsBox
{

    private $_timeZone = 'Europe/Paris';
    public static string $regexName = '/^[a-zA-zÀ-ú]+([\' .-]?[a-zA-zÀ-ú]+)*$/';
    public static string $regexWebsite = '/^(https?:\/\/(?:www\.)?[a-zA-Z0-9][a-zA-Z0-9-]+\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+\.[^\s]{2,})$/';
    public static string $regexPassword = '/(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*/';
    public static string $regexEmail = '/(?:[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)])/';


    /**
     * Sanitizes the provided HTML string by stripping or allowing specific tags.
     *
     * This function uses the HTMLPurifier library to sanitize the input HTML,
     * applying specific configurations to limit the allowed tags and settings for
     * external content and iframe usage.
     *
     * @param string $html The HTML input string to sanitize.
     * @return string The sanitized HTML string.
     */
    public static function sanitizeHtml(string $html): string
    {
        $config = HTMLPurifier_config::createDefault();
        $config->set('HTML.Allowed', 'b,strong,i,em,u,p,ul,ol,li,br,h1,h2,h3,h4,h5,h6');
        $config->set('URI.DisableExternal', true);
        $config->set('HTML.SafeIframe', false);
        $config->set('Attr.AllowedFrameTargets', []);

        $purifier = new HTMLPurifier($config);
        return $purifier->purify($html);
    }

    /** ARRAY / OBJECT */
    public static function arrayCheckResult($values): bool {
        return is_array($values) && !empty($values);
    }

    public static function arrayCheckKey($key,$array) {
        return array_key_exists($key,$array);
    }

    public static function objectCheckResult($values): bool {
        return is_object($values) && count($values) > 0;
    }

    public static function objectCheck($values): bool {
        return is_object($values);
    }

    public static function arraySort(array $array, string $key, $order=SORT_ASC): array
    {
        $new_array = array();
        $sortable_array = array();

        if (!empty($array)) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $key) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            if ($order === SORT_ASC) {
                asort($sortable_array);
            } else {
                arsort($sortable_array);
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[] = $array[$k];
            }

        }

        return $new_array;
    }

    public static function stdClassToArray(stdClass $class): array {

        $return = [];

        foreach ($class as $key => $value) {

            $return[$key] = $value;

        }

        return $return;

    }

    /**
     * Check if the query result is valid.
     *
     * @param mixed $result The query result to validate.
     *
     * @return bool Returns true if the result is valid, false otherwise.
     */
    public static function isValidQueryResult($result): bool {
        $isValid = false;

        if ($result !== null) {
            if (is_object($result)) {
                if ($result instanceof Countable) {
                    $isValid = count($result) > 0;
                } else {
                    $isValid = count(get_object_vars($result)) > 0;
                }
            } elseif (is_array($result)) {
                $isValid = count($result) > 0;
            }
        }

        return $isValid;
    }

    /**
     * Process the data with a recursive call to remove all duplicates.
     *
     * @param array $array
     * @return array
     */
    public static function removeDuplicates(array $array): array
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = self::removeDuplicates($value);
            }
        }

        return array_map("unserialize", array_unique(array_map("serialize", $array)));
    }

    /** ARRAY / OBJECT FIN */

    /** HTTP **/
    public static function httpResponse(int $code, string $message, array $data = []): array
    {

        return ['code'=>$code, 'message'=>$message, 'data'=>$data];

    }

    /** REQUEST */
    public static function dateWhereCondition(string $begin, string $end) {
        $return = null;
        return $return;
    }

    public static function monthWhereCondition(string $date) {
        $return = null;

        $dateInProgressBegin = date('Y-m-01' , strtotime($date));
        $dateInProgressEnd = date('Y-m-t 23:59:59' , strtotime($date));

        if($dateInProgressBegin < $dateInProgressEnd) {
            $return = array();
            $return['begin'] = $dateInProgressBegin;
            $return['end'] = $dateInProgressEnd;
        }

        return $return;
    }

    public static function encodeEmail(string $message) {
        return rtrim(strtr(base64_encode($message), '+/', '-_'), '=');
    }

    public static function getRequestIp(): string {
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }

    public static function requestCheckUpdate($nbRowsUpdated): bool
    {
        return $nbRowsUpdated >= 0;
    }

    public static function requestCheckDelete($nbRowsDeleted): bool
    {
        return $nbRowsDeleted >= 0;
    }

    public static function requestCheckSelect($result): bool
    {
        // Vérifie si le résultat n'est pas vide
        return !empty($result);
    }

    public static function likeCondition(string $value): string
    {
        return '%'.str_replace(' ','%',$value).'%';
    }


    /**
     * Sanitizes the provided string by replacing forbidden characters with asterisks (*), adding an asterisk
     * around non-empty words, and enclosing the entire string in single quotes.
     *
     * @param string $value The input string to sanitize and process.
     * @return string The processed string with forbidden characters replaced and formatted.
     */
    public static function againstCondition(string $value): string
    {
        $forbiddenCharacters = [
            '+', '-', '@', '<', '>', '(', ')', '~', '*', '"', "'"
        ];

        $sanitizedValue = str_replace($forbiddenCharacters, '*', $value);

        $words = explode(' ', $sanitizedValue);

        $processedWords = array_map(function ($word) {
            $trimmedWord = trim($word, '*');
            if (!empty($trimmedWord)) {
                return '*' . $trimmedWord . '*';
            }
            return null;
        }, $words);

        return "'".implode(' ', $processedWords)."'";
    }




    public static function json_arrayagg(array $values): string {

        $return = '';

        foreach ($values as $key => $value) {

            $return .= "'" . $key . "'," . $value . ',';

        }

        $return = substr($return,0,-1);

        return "CONCAT('[',GROUP_CONCAT(JSON_OBJECT(".$return.")),']')";
    }

    public static function escape_param(string $values) {
        return addslashes(trim($values));
    }
    /** REQUEST FIN */

    /** DATE */
    public static function googleDateFormat(string $date, string $timeZone) {
        $TimeZone = new DateTimeZone($timeZone);
        $Date = new DateTime($date,$TimeZone);
        return $Date->format('Y-m-d\TH:i:sP');
    }

    public static function convertGoogleDateFormat(string $date, string $timeZone = null) {
        if (isset($timeZone)) {
            $TimeZone = new DateTimeZone($timeZone);
            $Date = new DateTime($date,$TimeZone);
        } else {
            $Date = new DateTime($date);
        }

        return $Date->format('Y-m-d H:i:s');
    }

    public static function dateFormat(string $date = 'now', string $timeZone = 'Europe/Paris'): string
    {
        $TimeZone = new DateTimeZone($timeZone);
        $Date = new DateTime($date,$TimeZone);
        return $Date->format('Y-m-d H:i:s');
    }

    /**
     * @throws Exception
     */
    public static function date(string $date = 'now', string $timeZone = 'Europe/Paris'): DateTime|null {
        $TimeZone = new DateTimeZone($timeZone);
        return new DateTime($date,$TimeZone);
    }

    public static function dateFormatFront(string $date, string $timeZone = 'Europe/Paris'): string {
        $TimeZone = new DateTimeZone($timeZone);
        $Date = new DateTime($date,$TimeZone);
        return $Date->format('d/m/Y');
    }

    public static function dateTimeFormatFront(string $date , string $timeZone) {
        $TimeZone = new DateTimeZone($timeZone);
        $Date = new DateTime($date,$TimeZone);
        return $Date->format('d/m/Y à H:i');
    }

    public static function dateTimeFormatFrontFromOffice365(string $date): string {
        $dateTime = new DateTime($date);
        $dateTime->setTimezone(new DateTimeZone('Europe/Paris'));
        return $dateTime->format('d/m/Y H:i');
    }

    public static function frontFormatDate(string|null $date , string $timeZone):string {
        if(isset($date)) {
            $TimeZone = new DateTimeZone($timeZone);
            $Date = new DateTime($date,$TimeZone);
            return $Date->format('d/m/Y');
        } else {
            return '';
        }
    }

    public static function addTimeToDate(string $date, string $timeZone, string $time, string $typeType): string|null {
        try {
            $TimeZone = new DateTimeZone($timeZone);
            $Date = new DateTime($date,$TimeZone);
            $oldDay = $Date->format('d');
            switch ($typeType) {
                /** Year */
                case 'Y':
                    $Date->add(new DateInterval('P'.$time.'Y'));
                    break;
                /** Month */
                case 'M':
                    $Date->add(new DateInterval('P'.$time.'M'));
                    if($oldDay != $Date->format('d')) {
                        $Date->sub(new DateInterval("P" . $Date->format('d') . "D"));
                    }
                    break;
                /** Day */
                case 'D':
                    $Date->add(new DateInterval('P'.$time.'D'));
                    break;
                /** Hour */
                case 'H':
                    $Date->add(new DateInterval('PT'.$time.'H'));
                    break;
                /** Minute */
                case 'I':
                    $Date->add(new DateInterval('PT'.$time.'M'));
                    break;
                default:
                    break;
            }
            return $Date->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function subTimeToDate(string $date, string $timeZone, string $time, string $typeType): string|null
    {
        try {
            $TimeZone = new DateTimeZone($timeZone);
            $Date = new DateTime($date,$TimeZone);
            $oldDay = $Date->format('d');
            switch ($typeType) {
                /** Year */
                case 'Y':
                    $Date->sub(new DateInterval('P'.$time.'Y'));
                    break;
                /** Month */
                case 'M':
                    $Date->sub(new DateInterval('P'.$time.'M'));
                    if($oldDay != $Date->format('d')) {
                        $Date->sub(new DateInterval("P" . $Date->format('d') . "D"));
                    }
                    break;
                /** Day */
                case 'D':
                    $Date->sub(new DateInterval('P'.$time.'D'));
                    break;
                /** Hour */
                case 'H':
                    $Date->sub(new DateInterval('PT'.$time.'H'));
                    break;
                /** Minute */
                case 'I':
                    $Date->sub(new DateInterval('PT'.$time.'M'));
                    break;
                default:
                    break;
            }
            return $Date->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function cleanDateToBDD(string $date, string $timezone): string|null {
        if (isset($date) && strlen(trim($date)) >= 10 ) {
            return self::dateFormat($date,$timezone);
        } else {
            return null;
        }
    }

    public static function convertToHoursMins($time, $format = '%02d:%02d') {
        if ($time < 1) {
            return null;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

    public static function diffDate(string $dateFrom, string $dateTo, string $timezoneFrom = 'Europe/Paris', string $timezoneTo = 'Europe/Paris'){
        $dateFrom = self::date($dateFrom,$timezoneFrom);
        $dateTo = self::date($dateTo,$timezoneTo);

        return $dateTo->diff($dateFrom);
    }

    public static function getDifferenceDate(string $fromDate, string $timeZoneFrom, string $toDate, string $timeZoneTo): DateInterval{
        $fromDate = ToolsBox::date($fromDate, $timeZoneFrom);
        $toDate = ToolsBox::date($toDate, $timeZoneTo);

        $interval = $toDate->diff($fromDate);

        return $interval;
    }

    public static function dateFormatRelative(string $date, string $timeZone = 'Europe/Paris'): string
    {
        $date_a_comparer = new DateTime($date, new DateTimeZone($timeZone));
        $date_actuelle = new DateTime("now", new DateTimeZone($timeZone));

        $intervalle = $date_a_comparer->diff($date_actuelle);

        if ($date_a_comparer > $date_actuelle)
        {
            $prefixe = 'dans ';
        }
        else
        {
            $prefixe = 'il y a ';
        }

        $ans = $intervalle->format('%y');
        $mois = $intervalle->format('%m');
        $jours = $intervalle->format('%d');
        $heures = $intervalle->format('%h');
        $minutes = $intervalle->format('%i');
        $secondes = $intervalle->format('%s');

        if ($ans != 0)
        {
            $relative_date = $prefixe . $ans . ' an' . (($ans > 1) ? 's' : '');
            if ($mois >= 6) $relative_date .= ' et demi';
        }
        elseif ($mois != 0)
        {
            $relative_date = $prefixe . $mois . ' mois';
            if ($jours >= 15) $relative_date .= ' et demi';
        }
        elseif ($jours != 0)
        {
            $relative_date = $prefixe . $jours . ' jour' . (($jours > 1) ? 's' : '');
        }
        elseif ($heures != 0)
        {
            $relative_date = $prefixe . $heures . ' heure' . (($heures > 1) ? 's' : '');
        }
        elseif ($minutes != 0)
        {
            $relative_date = $prefixe . $minutes . ' minute' . (($minutes > 1) ? 's' : '');
        }
        else
        {
            $relative_date = $prefixe . ' quelques secondes';
        }

        return $relative_date;
    }
    /** END DATE */

    /** NUMBER */
    /**
     * @param float $to
     * @param float $from
     * @return float|int
     */
    //Calcule du pourcentage de variation (taux de variation ou d'évolution) entre deux valeurs
    #[Pure] public static function calculPourcentVariation(float $to, float $from): float {

        if ($from > 0) {
            $percent = (($to - $from) / $from) * 100;
        } else {
            $percent = 100;
        }

        return round($percent, 2, PHP_ROUND_HALF_UP);
    }

    #[Pure] public static function checkNumber($number): bool {

        return is_int($number) || is_float($number);

    }

    public static function calculPourcent(float $montantPartiel, float $montantTotal,$noRound = true): float {
        if($montantTotal == 0){
            return 0;
        }
        if ($noRound) {
            return round(($montantPartiel/$montantTotal)*100, 0, PHP_ROUND_HALF_UP);
        } else {
            return round(($montantPartiel/$montantTotal)*100, 2, PHP_ROUND_HALF_UP);
        }
    }

    public static function removePercent($number, $percent){
        $multi = $percent / 100 + 1;
        return round(self::cleanFloat($number) / $multi, 2, PHP_ROUND_HALF_UP);
    }

    public static function addPercent($number, $percent){
        $multi = $percent / 100 + 1;
        return round(self::cleanFloat($number) * $multi, 2, PHP_ROUND_HALF_UP);
    }

    public static function calculMontantPourcentage($montant, $pourcentage): float {
        return $montant * $pourcentage / 100;
    }

    public static function cleanNumberToBDD($number): float|int {


        $return = self::cleanFloat($number);

        $return = (float)$return;

        if (self::checkNumber($return)) {
            $return = self::roundFloat($return);
        } else {
            $return = 0;
        }

        if ($number < 0) {
            $return = $return * -1;
        }

        return $return;
    }

    public static function cleanNumberToFront($value): string {

        $number = str_replace('-','',$value);

        if(fmod($number, 1) !== 0.00){
            $number = number_format($number, 2, ',', ' ');
        } else {
            $number = number_format($number, 0, ',', ' ');
        }
        if ($value < 0 ) {
            $number = '-'.$number;
        }

        return $number;
    }

    public static function cleanFloat($montant) {
//        $montant =  str_replace(' ','',trim($montant));

        $montant =  preg_replace('/[^0-9.,]+/', '', $montant);

        return str_replace(',','.',$montant);
    }

    public static function roundFloat($number): float
    {
        return round($number, 2, PHP_ROUND_HALF_UP);
    }

    /**
     * Performs a linear conversion of a given number within a given range to another range.
     *
     * @param int $nombre The number to be converted.
     * @param int $minOld The minimum value of the old range. Defaults to 1.
     * @param int $maxOld The maximum value of the old range. Defaults to 3.
     * @param int $minNew The minimum value of the new range. Defaults to 1.
     * @param int $maxNew The maximum value of the new range. Defaults to 5.
     * @return int The converted number within the new range.
     */
    public static function linearConvertion(int $nombre,
                                            int $minOld = 1,
                                            int $maxOld = 3,
                                            int $minNew = 1,
                                            int $maxNew = 5) : int
    {
        $result = (($nombre-$minOld)/($maxOld-$minNew))*($maxNew-$minNew)+$minNew;

        return (int) max($minNew, min($maxNew, $result));
    }
    /** END NUMBER */


    /** FILE */
    public static function filePath(string $fileRoad ): bool{
        return file_exists($fileRoad);
    }

    public static function isAutorisedTypeFile(string $fileType): bool {
        $autorisedType = [
            '.doc',
            '.docx',
            '.pdf',
            '.xls',
            '.xlsx',
            '.jpeg',
            '.png',
            '.odt',
            '.ods',
            '.ppt',
            '.pptx',
            'image/png',
            'image/jpeg',
            'application/vnd.oasis.opendocument.text',
            'application/vnd.oasis.opendocument.spreadsheet',
            'application/pdf',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/msword',
            'application/vnd.ms-excel',
            'application/vnd.ms-powerpoint',
            'application/vnd.apple.keynote',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];
        return in_array($fileType,$autorisedType);
    }

    public static function imageEncode(string|null $image): string|null{

        return isset($image) ? base64_encode($image): null;

    }

    /**
     * Uploads an image from the base.
     *
     * @param int $tableId The ID of the table.
     * @param string $tableName The name of the table.
     * @param string $imageType The type of the image.
     * @param string $connection The database connection name.
     *
     * @return object|null        The uploaded image object, or null if not found.
     */
    public static function uploadImageFromBase(int    $tableId,
                                               string $tableName,
                                               string $imageType,
                                               string $connection): object|null
    {
        return DB::connection($connection)
            ->table(Schema::SPECIFIC_SCOPETENZA.'introduction as i')
            ->where([
                ['i.tableName', '=', $tableName],
                ['i.tableId', '=', $tableId],
            ])
            ->select(
                'i.'.$imageType.' as image' ,
                'i.'.$imageType.'MimeType as mimeType',
            )
            ->first();
    }

    /**
     * Loads the portal logo.
     *
     * @return string|null The encoded logo as a string if it exists, otherwise null.
     */
    public static function loadPortalLogo(): string|null
    {
        $logo = '/Users/julien/PhpstormProjects/scopetenza-back-lumen/public/template/image/lock.png';
        $logo = file_get_contents($logo);

        return ToolsBox::imageEncode($logo);

    }

    /**
     * Load the social media logos.
     *
     * @return array|null An array containing the encoded images of the Facebook, LinkedIn, and Instagram logos.
     */
    public static function loadSocialMediaLogo(): ?array
    {
        $socialMediaLogos = ['facebook', 'linkedin', 'instagram'];
        $result = [];

        foreach ($socialMediaLogos as $logo) {
            $path = config("mail.logos.{$logo}Logo.path");
            $logoContent = file_get_contents($path);
            $result[$logo] = ToolsBox::imageEncode($logoContent);
        }

        return $result;
    }

    /**
     * Loads social media URLs
     *
     * @return array|null An array containing social media URLs or null if no URLs are found
     */
    public static function loadSocialMediaUrl(): ?array
    {
        $socialMediaLogos = ['facebook', 'linkedin', 'instagram', 'youtube'];
        $result = [];

        foreach ($socialMediaLogos as $logo) {
            $result[$logo] = config("mail.logos.{$logo}.url");
        }

        return $result;
    }

    /** END FILE */

    /** BDD */
    public static function cleanTypeField(string $fieldType): string{

        $indice = strpos($fieldType,'(');

        if (!$indice) {
            return $fieldType;
        } else {
            return trim(substr($fieldType,0,$indice));
        }

    }

    public static function cleanDataField(string $fieldType,string|null $data): int|float|string|null {

        $value = $data;

        switch ($fieldType) {
            case 'int':
                $value = self::stringToInt($value);
                break;

            case 'float':
                $value = self::stringToFloat($value);
                break;

            case 'date':
                /** @var  $value - la valeur doit être null ou au format dd.mm.aaaa */
                $value = self::stringToDate($value);
                break;
            default:
                $value = trim($value);
                break;
        }

        return $value;

    }

    public static function cleanTinyInt(bool|string|int $value): int {
        return (int)$value;
    }

    public static function filterBeforeAdd(string $table_name, array $data, string $connection='admin'): array {
        $columnList = DB::connection($connection)->getSchemaBuilder()->getColumnListing($table_name);

        $return = array();
        foreach($data as $key => $values){
            if(in_array($key, $columnList)){
                $return[$key] = $values;
            }
        }

        return $return;
    }
    /** END BDD */


    /** STRING */
    public static function cleanLetterString($string) {
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē','é', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e','e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
        return str_replace($a, $b, $string);
    }

    public static function stringToInt(string|null $string): int {

        if (!isset($string)) {
            return 0;
        }

        $value = preg_replace('/[^0-9]+/', '', $string);

        return (int)$value;
    }

    public static function stringToFloat(string|null $string): int {

        if (!isset($string)) {
            return 0;
        }

        $value = $string;

        $value = self::cleanNumberToBDD($value);

        return (float)$value;

    }

    public static function stringToDate(string|null $string): string|null {

        if (isset($string)) {
            $date = self::dateFormat($string,'Europe/Paris');
        } else {
            $date = self::dateFormat(date('Y-m-d'),'Europe/Paris');
        }

        return $date;

    }

    public static function stringToDateSaleExportMiniconi(string|null $string): string|null {

        $arrayEnglish = ['january','february','march','april','may','june','july','august','september','october','november','december','jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec'];
        $arrayFrench = ['janvier','fevrier','mars','avril','mai','juin','juillet','aout','septembre','octobre','novembre','decembre','janvier','fevrier','mars','avril','mai','juin','juillet','aout','septembre','octobre','novembre','decembre'];

        $annee = '2019';
        $month = '';
        $day   = '';

        $buildDate = false;

        $date = null;

        $dateString = strtolower(self::cleanLetterString($string));

        $dateString = str_replace($arrayEnglish, $arrayFrench, $dateString);

        if (isset($string)) {
            if (self::stringPos($dateString,'jan') !== false) {
                $month = '01';
                $day   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } else if (self::stringPos($dateString,'fev') !== false) {
                $month = '02';
                $day   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } else if (self::stringPos($dateString,'mar') !== false) {
                $month = '03';
                $day   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } else if (self::stringPos($dateString,'av') !== false) {
                $month = '04';
                $day   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } else if (self::stringPos($dateString,'mai') !== false) {
                $month = '05';
                $day   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } else if (self::stringPos($dateString,'juin') !== false) {
                $month = '06';
                $day   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } else if (self::stringPos($dateString,'juil') !== false) {
                $month = '07';
                $day   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } else if (self::stringPos($dateString,'aout') !== false) {
                $month = '08';
                $day   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } else if (self::stringPos($dateString,'sep') !== false) {
                $month = '09';
                $day   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } else if (self::stringPos($dateString,'oct') !== false) {
                $month = '10';
                $day   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } else if (self::stringPos($dateString,'nov') !== false) {
                $month = '11';
                $day   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } else if (self::stringPos($dateString,'dec') !== false) {
                $month = '12';
                $day   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } else {
                if (strlen($dateString) === 10) {
                    $date = self::dateFormat(str_replace(',','.',$dateString),'Europe/Paris');
                } else if (strlen($dateString) <= 5) {
                    if (self::stringPos($dateString,'.') !== false) {
                        $dateString .= '.' . $annee;
                    } else {
                        $dateString .= '-' . $annee;
                    }
                    $date = self::dateFormat($dateString,'Europe/Paris');
                }
            }
            if ($buildDate) {
                $dateBuild = $day.'.'.$month.'.'.$annee;
                $date = self::dateFormat($dateBuild,'Europe/Paris');
            }
        } else {
            $date = self::dateFormat(date('Y-m-d'),'Europe/Paris');
        }

        return $date;

    }

    public static function stringToDateEntryStockExportMiniconi(string|null $string): string|null {

        $arrayEnglish = ['january','february','march','april','may','june','july','august','september','october','november','december','jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec'];
        $arrayFrench = ['janvier','fevrier','mars','avril','mai','juin','juillet','aout','septembre','octobre','novembre','decembre','janvier','fevrier','mars','avril','mai','juin','juillet','aout','septembre','octobre','novembre','decembre'];

        $annee = '';
        $month = '';
        $day   = '01';

        $buildDate = false;

        $date = null;

        $dateString = strtolower(self::cleanLetterString($string));

        $dateString = str_replace($arrayEnglish, $arrayFrench, $dateString);

        if (isset($string)) {
            if (self::stringPos($dateString,'jan') !== false) {
                $month = '01';
                $annee   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } elseif (self::stringPos($dateString,'fev') !== false) {
                $month = '02';
                $annee   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } elseif (self::stringPos($dateString,'mar') !== false) {
                $month = '03';
                $annee   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } elseif (self::stringPos($dateString,'av') !== false) {
                $month = '04';
                $annee   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } elseif (self::stringPos($dateString,'mai') !== false) {
                $month = '05';
                $annee   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } elseif (self::stringPos($dateString,'juin') !== false) {
                $month = '06';
                $annee   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } elseif (self::stringPos($dateString,'juil') !== false) {
                $month = '07';
                $annee   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } elseif (self::stringPos($dateString,'aout') !== false) {
                $month = '08';
                $annee   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } elseif (self::stringPos($dateString,'sep') !== false) {
                $month = '09';
                $annee   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } elseif (self::stringPos($dateString,'oct') !== false) {
                $month = '10';
                $annee   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } elseif (self::stringPos($dateString,'nov') !== false) {
                $month = '11';
                $annee   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } elseif (self::stringPos($dateString,'dec') !== false) {
                $month = '12';
                $annee   = (string)self::stringToInt($dateString);
                $buildDate = true;
            } else {
                if (strlen($dateString) <= 5) {
                    if (self::stringPos($dateString,'.') !== false) {
                        $dateString .= '.' . $annee;
                    } else {
                        $dateString .= '-' . $annee;
                    }
                    $date = self::dateFormat($dateString,'Europe/Paris');
                }
            }
            if ($buildDate) {
                if (strlen((string)trim($annee)) < 4) {
                    if ($annee == 0) {
                        $annee = '2019';
                    } else {
                        $annee = '20'.$annee;
                    }
                }
                $dateBuild = $day.'.'.$month.'.'.$annee;

                $date = self::dateFormat($dateBuild,'Europe/Paris');
            }
        }

        return $date;

    }

    public static function stringPos(string $string, string $stringToSearch): int|false {
        return strpos($string,$stringToSearch);
    }

    public static function firsMajString(string $string): string {
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'D', 'Ñ','N', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $b = array('à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'd', 'ñ','n', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

        return str_replace($b,$a,substr($string,0,1)).substr($string,1);
    }

    public static function majString(string $string): string {
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'D', 'Ñ','N', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $b = array('à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'd', 'ñ','n', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        return str_replace($b,$a,$string);
    }

    public static function minstring(string $string): string{
        $b = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'D', 'Ñ','N', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $a = array('à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'd', 'ñ','n', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        return str_replace($b,$a,$string);
    }

    public static function cleanString(string|null $value ): string|null {

        $return = trim($value);

        if ($return === '' || !isset($return)) {

            return null;

        }

        return $return;

    }

    public static function boolToWord(bool|string|int|null $value): string {
        $return = '';

        if ($value != null) {
            if ($value === true || self::minstring($value) == 'true' || $value == '1' || $value == 1) {
                $return = 'oui';
            } elseif ($value === false || self::minstring($value) == 'false' || $value == '0' || $value == 0) {
                $return = 'non';
            }
        }

        return $return;
    }

    public static function wordToBool(bool|string|int|null $value): bool {
        $return = false;

        if ($value != null) {
            if ($value === true || self::minstring($value) == 'true' || $value == '1' || $value == 1) {
                $return = true;
            } elseif ($value === false || self::minstring($value) == 'false' || $value == '0' || $value == 0) {
                $return = false;
            }
        }

        return $return;
    }

    public static function cleanFileName($name){
        $name = self::cleanLetterString($name);
        $name = str_replace("'","",$name);
        return str_replace(" ","",$name);
    }

    public static function userNameFormat(string|null $nom, string|null $prenom): string {

        $nom = (isset($nom)) ? self::majString($nom) : '';
        $prenom = (isset($prenom)) ? self::firsMajString($prenom) : '';

        return $nom . ' ' . $prenom;
    }

    public static function arrayToStringWithVirguleAndEt(array $array): string {
        $return = '';

        if (self::arrayCheckResult($array)) {
            $string = join(', ',$array);
            $pos = strrpos($string,',');

            if ($pos !== false) {
                $return = substr_replace($string,' et',$pos,1);
            }
        }

        return $return;
    }

    //peut être il faudrai aussi vérifier la langue
    public static function singularOrPlural(string|null $name, int|null $nb): string|null {

        if(isset($name) && isset($nb) && $nb > 1 && (!in_array($name, ['mois']))){
            $name .= 's';
        }

        return $name;
    }

    public static function cleanSpaceFromString(string $string): string
    {
        return str_replace(' ','',$string);
    }

    public static function capitalizeWords(string $str): string
    {
        $str = strtolower($str);
        $delimiter = " ";
        if(str_contains($str, "-")) {
            $delimiter = "-";
        }
        $words = explode($delimiter, $str);

        for ($i = 0; $i < count($words); $i++) {
            $words[$i] = ucfirst($words[$i]);
        }

        return implode($delimiter, $words);
    }

    /**
     * Format a full name string by keeping the first name and first letter of last name with a period
     *
     * @param string $fullName The full name in format "firstname lastname"
     * @return string The formatted name like "firstname L."
     */
    public static function formatNameWithInitial(string $fullName): string
    {
        $nameParts = explode(' ', $fullName);
        if (count($nameParts) < 2) {
            return $fullName;
        }

        $firstName = $nameParts[0];
        $lastName = ucfirst($nameParts[1]);

        return $firstName . ' ' . substr($lastName, 0, 1) . '.';
    }

    /**
     * Sanitizes the given string by removing unwanted or potentially harmful content.
     *
     * This function utilizes the HTMLPurifier library to clean the input string
     * and ensure it conforms to safe standards.
     *
     * @param string $string The input string to be sanitized.
     *
     * @return string The sanitized string.
     */
    public static function sanitizeString(string $string): string
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        return $purifier->purify($string);
    }



    /** STRING END */


    /** REGEX */
    public static function cleanPattern(string $pattern): string {
        $search = ['/'];
        $replace = ['\/'];

        return str_replace($search,$replace,$pattern);
    }

    public static function match(string $pattern, string $subject, array|string &$matches = null, bool $all = true): bool {
        if ($all) {
            $match = preg_match_all($pattern, $subject, $matches);
        } else {
            $match = preg_match($pattern, $subject, $matches);
        }

        return $match !== false && $match > 0;
    }

    /**
     * Récupère le texte entre deux délimiteurs.
     *
     * @param string $subject Le texte à parcourir.
     * @param string $firstDelimiter Le premier délimiteur.
     * @param string $lastDelimiter Le second délimiteur.
     * @param array|string|null $matches Le tableau de résultat.
     * @param bool $all
     * @return bool Retourne true s'il y a une correspondence dans le sujet.
     */
    public static function matchBetween(string $subject, string $firstDelimiter, string $lastDelimiter, array|string &$matches = null, bool $all = true): bool {
        $firstDelimiter = self::cleanPattern($firstDelimiter);
        $lastDelimiter = self::cleanPattern($lastDelimiter);

        $pattern = '/(?<=' . $firstDelimiter . ').*?(?=' . $lastDelimiter . ')/';

        return self::match($pattern,$subject,$matches,$all);
    }

    /**
     * Récupère le texte depuis un délimiteur jusqu'a un autre.
     *
     * @param string $subject Le texte à parcourir.
     * @param string $from Le premier délimiteur.
     * @param string $to Le second délimiteur.
     * @param array|string|null $matches Le tableau de résultat.
     * @param bool $all
     * @return bool Retourne true s'il y a une correspondence dans le sujet.
     */
    public static function matchFromTo(string $subject, string $from, string $to, array|string &$matches = null, bool $all = true): bool {
        $from = self::cleanPattern($from);
        $to = self::cleanPattern($to);

        $pattern = '/' . $from . '.*?' . $to . '/';

        return self::match($pattern,$subject,$matches,$all);
    }

    public static function matchNumber(string $subject, array|string &$matches = null, bool $all = true): bool {
        $pattern = '/\d+/';

        return self::match($pattern,$subject,$matches,$all);
    }

    public static function matchFacebookLink(string $subject, array|string &$matches = null, bool $all = true): bool {
        $pattern = '/(?:(?:http|https):\/\/)?(?:www.|m.)?facebook.com\/(?!home.php)(?:\w*#!\/)?(?:pages\/)?(?:[?\w\-]*\/)?(?:profile.php\?id=(?=\d.*))?([\w.-]+)(\/)?/';

        return self::match($pattern,$subject,$matches, $all);
    }

    public static function matchTwitterLink(string $subject, array|string &$matches = null, bool $all = true): bool {
        $pattern = '(https://twitter.com/(?![a-zA-Z0-9_]+/)([a-zA-Z0-9_]+))';

        return self::match($pattern,$subject,$matches, $all);
    }

    public static function matchYoutubeLink(string $subject, array|string &$matches = null, bool $all = true): bool {
        $pattern = '/(?:https|http):\/\/(?:\w+\.)?youtube\.com\/(?:c\/|channel\/|user\/|@)?([a-zA-Z0-9\-_]+)(\/)?/';

        return self::match($pattern,$subject, $matches, $all);
    }

    public static function matchInstagramLink(string $subject, array|string &$matches = null, bool $all = true): bool {
        $pattern = '/(?:(?:http|https):\/\/)?(?:www.)?(?:instagram.com|instagr.am|instagr.com)\/([\w.-]+)(\/)?/';

        return self::match($pattern,$subject,$matches, $all);
    }

    public static function matchLinkedinLink(string $subject, array|string &$matches = null, bool $all = true): bool {
        $pattern = '/(?:(?:http|https):\/\/)?(?:www.)?linkedin\.com\/(pub|in|profile|company|school)\/([\w.-]+)(\/)?/';

        return self::match($pattern,$subject,$matches, $all);
    }
    /** REGEX END */

    /** RETURN */
    public static function arrayResponse(int $code, string $message, array $data = [], array $errors = []): array{
        $return = [
            'code' => $code,
            'message' => $message
        ];

        if (self::arrayCheckResult($data)){
            $return['data'] = $data;
        }

        if (self::arrayCheckResult($errors)){
            $return['errors'] = $errors;
        }

        return $return;
    }
    /** RETURN END */

    /** VALIDATOR */
    /**
     * Valide les données selon les règles définies.
     *
     * @param array $data Données à valider.
     * @param array $rules Règles à appliquer.
     * @param array $messages Messages d'erreur à retourner.
     * @return bool|array Retourne true si les données sont valides ou la liste des erreurs.
     */
    public static function validateInput(array $data, array $rules, array $messages = array()): bool|array
    {
        $_messages = [
            'accepted' => __('validator.accepted'),
            'after' => __('validator.after'),
            'array' => __('validator.array'),
            'before' => __('validator.before'),
            'date_format' => __('validator.date_format'),
            'email' => __('validator.email'),
            'image' => __('validator.image'),
            'in' => __('validator.in'),
            'integer' => __('validator.integer'),
            'max' => __('validator.max'),
            'min' => __('validator.min'),
            'numeric' => __('validator.numeric'),
            'regex' => __('validator.regex'),
            'required' => __('validator.required'),
            'required_if' => __('validator.required_if'),
            'size' => __('validator.size'),
            'string' => __('validator.string'),
            'mimes' => __('validator.mimes'),
        ];

        if (ToolsBox::arrayCheckResult($messages)) {
            foreach ($messages as $k => $v) {
                $_messages[$k] = $v;
            }
        }

        $validator = Validator::make($data, $rules, $_messages);

        if ($validator->fails()) {
            return $validator->errors()->getMessages();
        } else {
            return true;
        }
    }
    /** VALIDATOR END*/

    /** SERVER */
    public static function getBaseUrl(): string
    {
        $protocol = (!empty($_SERVER['HTTPS'])
            && $_SERVER['HTTPS'] !== 'off'
            || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        return $protocol . $_SERVER['SERVER_HOST'];

    }

    /** END SERVER */

    /**
     * Loads a blocklist from a file.
     *
     * @param string $filePath The path of the file containing the blocklist.
     *
     * @return array|false The loaded blocklist as an array of strings, or false if the file does not exist.
     */

    public static function loadBlacklist(): array|false
    {
        $filePath = base_path('config/' . 'email_blocklist.txt');
        if (!file_exists($filePath)) {
            return [];
        }
        return file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

    /**
     * Determines if an email is from a disposable domain.
     *
     * This function extracts the domain from the given email and checks if it is in the provided blacklist.
     *
     * @param string $email The email address to check.
     * @param array $blacklist An array containing the disposable domains to check against.
     * @return bool Returns true if the email is from a disposable domain, otherwise false.
     */
    public static function isDisposableEmail(string $email, array $blacklist): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        return in_array($domain, $blacklist);
    }

    /** EMAILS END */

    /** ADDRESS */
    public static function getZipCode(string $adresse): string
    {
        $zipCode = '';

        preg_match_all('!\d+!', $adresse, $matches);
        foreach ($matches[0] as $match){
            if(strlen($match) === 5) {
                $zipCode = $match;
            }
        }

        return $zipCode;

    }
    /** ADDRESS END */

    /**
     * Checks if a user activity token is still valid based on the expiration date.
     *
     * @param string|null $dateExpireToken The expiration date of the token in a string format. If null or empty, the token is considered invalid.
     *
     * @return bool Returns true if the current time is within 55 minutes before the token expiration date, false otherwise.
     *
     * @throws Exception If the provided expiration date is invalid or cannot be parsed into a DateTime object.
     */
    public static function getUserActivity(?string $dateExpireToken): bool
    {
        if (empty($dateExpireToken)) {
            return false;
        }
        try {
            $tokenDate = new DateTime($dateExpireToken, new \DateTimeZone('Europe/Paris'));
            $tokenDateMinus60 = clone $tokenDate;
            $tokenDateMinus55 = clone $tokenDate;
            $tokenDateMinus60->modify('-60 minutes');
            $tokenDateMinus55->modify('-55 minutes');
            $now = new DateTime('now', new \DateTimeZone('Europe/Paris'));

            return $now >= $tokenDateMinus60 && $now <= $tokenDateMinus55;
        } catch (Exception $exception) {
            error_log($exception);
            return false;
        }
    }


}
