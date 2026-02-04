<?php

namespace App\Http\Repository\Community\PostComment;

use App\Exceptions\RepositoryException;
use App\Http\Entities\Post\PostCommentLike;
use App\Http\Repository\MainRepository;
use Exception;

class PostCommentLikeRepository extends MainRepository
{
    public function checkIfPostCommentLikeExists (int $postCommentLikeId): bool{

    }
    public function likePostComment (int $userId,int $postCommentId): array{

    }
    public function unlikePostComment (int $userId, int $postCommentId): array{

    }
    public function hardDeletePostCommentLike (int $postCommentLikeId): array{

    }
}