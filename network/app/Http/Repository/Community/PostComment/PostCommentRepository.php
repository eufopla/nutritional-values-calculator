<?php

namespace App\Http\Repository\Community\PostComment;

use App\Exceptions\RepositoryException;
use App\Http\Entities\Post\PostComment;
use App\Http\Repository\MainRepository;
use Exception;

class PostCommentRepository extends MainRepository
{
    public function checkIfPostCommentExists (int $postCommentId): bool{

    }
    public function publishPostComment (int $userId,int $postId): array{

    }
    public function updatePostComment (int $userId, int $postCommentId): array{

    }
    public function updatePostCommentStatus (int $userId, int $postCommentId): array{

    }
    public function hardDeletePostComment (int $postCommentId): array{

    }
}