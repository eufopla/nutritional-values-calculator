<?php

namespace App\Http\Repository\Community\Post;

use App\Exceptions\RepositoryException;
use App\Http\Entities\Post\PostLike;
use App\Http\Repository\MainRepository;
use Exception;

class PostLikeRepository extends MainRepository
{
    public function checkIfPostLikeExists (int $postLikeId): bool{

    }
    public function likePost (int $userId, int $postId): bool{

    }
    public function unlikePost (int $userId, int $postId): bool{

    }
    public function hardDeletePostLike (int $postLikeId): bool{

    }
    public function countPostLike (int $postId): int{

    }
}