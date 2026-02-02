<?php

namespace App\Http\Models;

use App\Http\Tools\Logger;
use App\Http\Tools\Session;
use App\Http\Tools\ToolsBox;
use App\Jobs\MailjetJob;
use Exception;
use Illuminate\Http\Client\Response;

/**
 * Class MainModel
 */
class MainModel
{
    // BDD
    protected string $_connectionShared = 'scopetenza_shared_db';
    protected string $_connectionSpecific = 'specific_db';
    protected string $_connectionSpecificMatching = 'matching_specific_db';

    // Exécution
    protected int $_code = 0;
    protected string $_message = '';
    protected array $_data = [];


    /**
     * Get the data
     *
     * @return array The data
     */
    public function getData(): array
    {
        return $this->_data;
    }

    /**
     * Code d'exécution
     * @return int
     */
    public function getCode(): int
    {
        return $this->_code;
    }

    /**
     * Message d'exécution
     * @return string
     */
    public function getMessage(): string
    {
        return $this->_message;
    }

    /**
     * Log an exception and set error code and message
     *
     * @param Exception $exception
     * @throws Exception
     */
    protected function logException(Exception $exception): void
    {
        $this->_code = 500;
        $this->_message = 'Une erreur serveur s\'est produite. Merci de contacter votre administrateur.';
        Logger::logException($exception);
    }

    /**
     * Logs an error with detailed information including time, server details, user ID, and error message.
     * Formats the log message for both logging and email notification. Sends an email about the error.
     *
     * @param int $code The error code to log.
     * @param string $message The error message to log.
     * @return void
     */
    protected function logError(int $code, string $message): void
    {
        Logger::logError($code, $message);
    }

    /**
     * Handles an exception by logging it (if applicable) and generating an HTTP response.
     *
     * @param Exception $exception The exception to handle.
     * @return array The HTTP response generated based on the exception details.
     * @throws Exception
     */
    public function exceptionHandlerAndHttpResponse(Exception $exception): array
    {
        $this->logException($exception);
        $code = $exception->getCode();
        $code = (is_int($code) && $code >= 100 && $code < 600) ? $code : 500;
        return ToolsBox::httpResponse($code, $exception->getMessage());
    }

}
