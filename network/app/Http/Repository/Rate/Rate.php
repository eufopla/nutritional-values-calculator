<?php

namespace App\Http\Repository\Rate;

use App\Exceptions\RepositoryException;
use App\Http\Entities\Rate\Rate;
use App\Http\Repository\MainRepository;
use Exception;

class RateRepository extends MainRepository
{
    public function checkIfRateExists (int $postId): bool{

    }
    public function createRate (int $userId, int $targetUserId): bool{

    }
    
    public function updateRateStatus (int $userId, int $rateId): array{

    }
    public function hardDeleteRate (int $rateId): array{

    }
}