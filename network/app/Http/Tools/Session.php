<?php


namespace App\Http\Tools;

class Session
{

    private static int $_idUtilisateur = 0;
    private static string $_portalName = '';
    private static int $_portalId = 1;
    private static string $_appKey = '';
    private static string $_languageCode = 'fr';
    private static int $_tableId = 0;
    private static string $_tableName = 'candidate';
    private static string $_role = 'user';
    private static string $idToken ='';


    public static function set(string $param, $value): void
    {
        $_SESSION[$param] = $value;
    }

    /**
     * Get the value of a specific session variable.
     *
     * This method retrieves the value of a session variable specified by the given parameter name.
     * If the session variable exists, it will return its value. Otherwise, it will return null.
     *
     * @param string $param The name of the session variable to retrieve.
     * @return mixed|null The value of the session variable, or null if it does not exist.
     */
    public static function get(string $param): mixed
    {
        return $_SESSION[$param] ?? null;
    }



    #### --------- SETTERS --------- ####

    /**
     * Sets the ID token.
     *
     * @param string $idToken The ID token to be set.
     * @return void
     */
    public static function setIdToken(string $idToken): void
    {
        self::$idToken = $idToken;
    }


    /**
     * Sets the ID of the user.
     *
     * This method is responsible for setting the ID of the user,
     * which will be stored in the private static property $_idUtilisateur.
     *
     * @param int $id The ID of the user.
     *
     * @return void
     */
    public static function setIdUser(int $id): void {
        self::$_idUtilisateur = $id;
    }

    /**
     * Sets the application key.
     *
     * This method updates the application key with the provided value.
     *
     * @param string $key The new application key.
     * @return void
     */
    public static function setAppKey(string $key): void {
        self::$_appKey = $key;
    }

    /**
     * Sets the language code.
     *
     * This method updates the language code with the provided value and sets the language using the updated code.
     *
     * @param string $code The new language code.
     * @return void
     */
    public static function setLanguageCode(string $code): void {
        self::$_languageCode = $code;
        Language::setLanguage(self::$_languageCode);
    }

    /**
     * Sets the table ID.
     *
     * This method updates the table ID with the provided value.
     *
     * @param int $id The new table ID.
     * @return void
     */
    public static function setTableId(int $id): void {
        self::$_tableId = $id;
    }

    /**
     * Sets the table name.
     *
     * This method updates the table name with the provided value.
     *
     * @param string $name The new table name.
     * @return void
     */
    public static function setTableName(string $name): void {
        self::$_tableName = $name;
    }


    #### --------- GETTERS --------- ####

    /**
     * Retrieves the ID token.
     *
     * @return string The ID token.
     */
    public function getIdToken(): string
    {
        return self::$idToken;
    }

    /**
     * Retrieves the user ID.
     *
     * This method returns the user ID stored in the private static property $_idUtilisateur.
     *
     * @return int The user ID.
     */
    public static function getIdUser(): int {
        return self::$_idUtilisateur;
    }

    /**
     * Retrieves the application key.
     *
     * This method returns the current application key.
     *
     * @return string The application key.
     */
    public static function getAppKey(): string {
        return self::$_appKey;
    }

    /**
     * Returns the language code.
     *
     * This method retrieves the language code that is stored in the application.
     *
     * @return string The language code.
     */
    public static function getLanguageCode(): string {
        return self::$_languageCode;
    }


    /**
     * Returns the table ID.
     *
     * @return int The table ID.
     */
    public static function getTableId(): int {
        return self::$_tableId;
    }


    /**
     * Returns the table name.
     *
     * @return string The table name.
     */
    public static function getTableName(): string {
        return self::$_tableName;
    }
}
