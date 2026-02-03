<?php

namespace App\Http\Tools;

use App\Jobs\MailjetJob;
use Exception;

class Logger
{
    public static function logException(Exception $exception): void
    {
        date_default_timezone_set('Europe/Paris');
        $time = date('Y-m-d H:i:s');
        $serverName = $_SERVER['SERVER_NAME'] ?? 'Unknown';
        $serverAddr = $_SERVER['SERVER_ADDR'] ?? 'Unknown';
        $userId = Session::getIdUser() ?? 'Unknown';

        $message = "Time: $time\n"
            . "Server: $serverName\n"
            . "ServerAddress: $serverAddr\n"
            . "UserId: $userId\n"
            . "Exception: $exception";

        error_log($message);

        // Email format
        $html = "
            <div style='font-family: Arial; padding: 20px;'>
                <p><strong>Time:</strong> $time</p>
                <p><strong>Server:</strong> $serverName</p>
                <p><strong>Server Address:</strong> $serverAddr</p>
                <p><strong>User ID:</strong> $userId</p>
                <p>$exception</p>
            </div>
        ";
    }


    public static function logError(int $code, string $message): void
    {
        $time = date('Y-m-d H:i:s');
        $serverName = $_SERVER['SERVER_NAME'] ?? 'Unknown';
        $serverAddr = $_SERVER['SERVER_ADDR'] ?? 'Unknown';
        $userId = Session::getIdUser() ?? 'Unknown';

        $log = "Time: $time\n"
            . "Server: $serverName\n"
            . "ServerAddress: $serverAddr\n"
            . "UserId: $userId\n"
            . "Error: Code $code - $message";

        error_log($log);

        $html = "
            <div style='font-family: Arial; padding: 20px;'>
                <p><strong>Time:</strong> $time</p>
                <p><strong>Server:</strong> $serverName</p>
                <p><strong>Server Address:</strong> $serverAddr</p>
                <p><strong>User ID:</strong> $userId</p>
                <p>$log</p>
            </div>
        ";
    }

}
