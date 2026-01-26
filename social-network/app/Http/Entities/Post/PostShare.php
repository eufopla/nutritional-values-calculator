<?php

namespace App\Http\Entities\Post;

use App\Http\Entities\MainEntity;

class PostShare extends MainEntity
{
    public ?int $id = null;
    public ?int $idPost = null;
    public ?int $idUser = null;
    public ?int $idUserReceiver = null;
    public ?string $content = null;
    public ?string $createdAt = null;
    
}