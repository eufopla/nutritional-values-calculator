<?php

namespace App\Http\Repository\Community\PostFeedback;

use App\Exceptions\RepositoryException;
use App\Http\Repository\MainRepository;
use Exception;

class PostFeedbackRepository extends MainRepository
{
    public function checkIfPostFeedbackExists (int $postId): bool{

    }
    public function publishPostFeedback (int $userId): array{

    }
    public function updatePostFeedback (int $userId, int $postId): array{

    }
    public function updatePostFeedbackStatus (int $userId, int $postId): array{

    }
    public function hardDeletePostFeedback (int $postId): array{

    }
}