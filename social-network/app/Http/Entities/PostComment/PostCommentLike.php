<?php

namespace App\Http\Entities\PostComment;

use App\Http\Entities\MainEntity;

class PostCommentLike extends MainEntity
{
    public ?int $id;
    public ?int $idUser;
    public ?int $idComment;
    public ?string $status = 'active';
    public ?string $createdAt;
    public ?string $updatedAt;
}