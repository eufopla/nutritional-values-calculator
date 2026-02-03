<?php

namespace App\Http\Entities\Community\Post;

use App\Http\Entities\MainEntity;

class PostPicture extends MainEntity
{
    public ?int $id;
    public ?int $postId;
    public ?string $path;
    public ?string $status = 'active';
    public ?string $createdAt;
    public ?string $updatedAt;
}
