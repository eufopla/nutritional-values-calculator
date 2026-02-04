<?php

namespace App\Http\Repository\Follow;

use App\Exceptions\RepositoryException;
use App\Http\Entities\Follow\Follow;
use App\Http\Repository\MainRepository;
use Exception;

class FollowDataRepository extends MainRepository
{
    public function getFollowDetails(int $id): ?Follow {

    }
}