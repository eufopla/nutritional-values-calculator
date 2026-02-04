<?php

namespace App\Http\Repository\Community\Post;

use App\Exceptions\RepositoryException;
use App\Http\Entities\Post\PostPicture;
use App\Http\Repository\MainRepository;
use Exception;

class PostPictureRepository extends MainRepository
{
    public function checkIfPostPictureExists (int $postPictureId): bool{

    }
    public function addPostPicture (int $userId, int $postId): array{

    }
    public function softDeletePostPicture (int $userId, int $postId, int $postPictureId): array{

    }
    public function hardDeletePostPicture (int $postPictureId): array{

    }
}