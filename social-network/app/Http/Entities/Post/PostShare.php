<?php

namespace App\Http\Entities\Post;

use App\Http\Entities\MainEntity;

class PostShare extends MainEntity
{
    public ?int $id = null;
    public ?int $postId = null;
    public ?int $userId = null;
    public ?int $receiverUserId = null;
    public ?string $createdAt = null;
    
}