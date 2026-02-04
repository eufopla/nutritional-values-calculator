<?php

namespace App\Http\Repository\Follow;

use App\Exceptions\RepositoryException;
use App\Http\Entities\Follow\Follow;
use App\Http\Repository\MainRepository;
use Exception;

class FollowRepository extends MainRepository
{
    public function find(int $id): ?Follow {

    }
    public function getUserFollows (int $userId): array{

    }
    public function getUserFollowers (int $userId): array{

    }
    public function checkIfFollowExists (int $userId1, int $userId2): bool{

    }
    public function follow (int $userId): array{

    }
    public function unfollow (int $userId): array{

    }
    public function hardDeleteFollow (int $userId): array{

    }
}