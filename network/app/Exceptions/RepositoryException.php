<?php

namespace App\Exceptions;

use App\Http\Tools\Logger;
use Exception;
use Throwable;

class RepositoryException extends Exception
{
    public function __construct(
        string $message = "Repository error",
        int $code = 500,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        Logger::logException($previous ?? $this);
    }
}