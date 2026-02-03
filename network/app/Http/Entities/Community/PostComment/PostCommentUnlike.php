<?php

namespace App\Http\Entities\Community\PostComment;

use App\Http\Entities\MainEntity;

class PostCommentUnlike extends MainEntity
{
    public ?int $id;
    public ?int $idUser;
    public ?int $idComment;
    public ?string $status = 'active';
    public ?string $createdAt;
    public ?string $updatedAt;
}