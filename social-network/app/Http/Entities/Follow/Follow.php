<?php

namespace App\Http\Entities\Follow;

use App\Http\Entities\MainEntity;

class Follow extends MainEntity
{
    public ?int $id = null;
    public ?int $idUserFollowing = null;
    public ?int $idUserFollowed = null;
    public ?string $status = 'active';
    public ?string $createdAt = null;
    public ?string $updatedAt = null;
}