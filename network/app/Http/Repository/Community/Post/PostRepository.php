<?php

namespace App\Http\Repository\Post;

use App\Exceptions\RepositoryException;
use App\Http\Entities\Post\Post;
use App\Http\Repository\MainRepository;
use Exception;

class PostRepository extends MainRepository
{
    public function checkIfPostExists (int $postId): bool{

    }
    public function publishPost (int $userId): array{

    }
    public function updatePost (int $userId, int $postId): array{

    }
    public function updatePostStatus (int $userId, int $postId): array{

    }
    public function hardDeletePost (int $postId): array{

    }
}