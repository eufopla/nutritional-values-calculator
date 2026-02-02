<?php

namespace App\Http\Entities\Post;

use App\Http\Entities\MainEntity;

class PostLike extends MainEntity
{
    public ?int $id;
    public ?int $userId;
    public ?int $postId;
    public ?string $status = 'active';
    public ?string $createdAt;
    public ?string $updatedAt;
}