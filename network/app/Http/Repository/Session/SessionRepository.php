<?php

namespace App\Http\Repository\Session;

use App\Exceptions\RepositoryException;
use App\Http\Entities\Session\Session;
use App\Http\Repository\MainRepository;
use Exception;

class RateRepository extends MainRepository
{
    public function checkIfSessionExists (int $sessionId): bool{

    }
    public function createSession (int $userId): bool{

    }
    
    public function updateSessionStatus (int $userId, int $sessionId): array{

    }
    public function hardDeleteSession (int $sessionId): array{

    }
}