<?php

namespace App\Http\Entities\Post;

use App\Http\Entities\MainEntity;

class PostPicture extends MainEntity
{
    public ?int $id;
    public ?int $idPost;
    public ?string $path;
    public ?string $status = 'active';
    public ?string $createdAt;
    public ?string $updatedAt;
}
