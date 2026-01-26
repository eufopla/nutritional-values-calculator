<?php

namespace App\Http\Entities\Post;

use App\Http\Entities\MainEntity;

class PostComment extends MainEntity
{
    public ?int $id;
    public ?int $idPost;
    public ?int $idUser;
    public ?string $content;
    public ?string $status = 'active';
    public ?string $createdAt;
    public ?string $updatedAt;
}
