<?php

namespace App\Http\Entities\Post;

use App\Http\Entities\MainEntity;

class Share extends MainEntity
{
    public ?int $id = null;
    public ?int $idPost = null;
    public ?int $idUserFollowed = null;
    public ?string $status = 'active';
    public ?string $createdAt = null;
    public ?string $updatedAt = null;
}