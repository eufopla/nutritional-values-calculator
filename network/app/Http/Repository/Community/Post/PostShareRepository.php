<?php

namespace App\Http\Repository\Community\Post;

use App\Exceptions\RepositoryException;
use App\Http\Entities\Post\PostShare;
use App\Http\Repository\MainRepository;
use Exception;

class PostShareRepository extends MainRepository
{
    public function share (int $userId, int $postId, int $receiverUserId): array{

    }
    public function hardDeletePostShare (int $postLikeId): bool{

    }
    public function countPostShare (int $postId): int{

    }

}