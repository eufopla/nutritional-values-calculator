<?php

namespace App\Http\Entities\Post;

use App\Http\Entities\MainEntity;

class PostLike extends MainEntity
{
    public ?int $id;
    public ?int $idUser;
    public ?int $idPost;
    public ?string $status = 'active';
    public ?string $createdAt;
    public ?string $updatedAt;
}