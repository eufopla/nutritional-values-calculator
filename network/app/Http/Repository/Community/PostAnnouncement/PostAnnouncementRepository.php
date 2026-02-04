<?php

namespace App\Http\Repository\Community\PostAnnouncement;

use App\Exceptions\RepositoryException;
use App\Http\Entities\PostAnnouncement\PostAnnouncement;
use App\Http\Repository\MainRepository;
use Exception;

class PostAnnouncementRepository extends MainRepository
{
    public function checkIfPostAnnoucementExists (int $postId): bool{

    }
    public function publishPostAnnouncement (int $userId): array{

    }
    public function updatePostAnnouncement (int $userId, int $postId): array{

    }
    public function updatePostAnnoucementStatus (int $userId, int $postId): array{

    }
    public function hardDeletePostAnnouncement (int $postId): array{

    }
}