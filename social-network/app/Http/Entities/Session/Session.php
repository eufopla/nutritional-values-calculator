<?php

namespace App\Http\Entities\PostAnnoucement;

use App\Http\Entities\MainEntity;

class PostAnnoucement extends MainEntity
{
    public ?int $id;
    public ?string $type;
    public ?int $authorUserId;
    public ?int $joiningUserId;
    public ?string $theme;
    public ?string $createdAt;
    public ?string $finishedAt;
}