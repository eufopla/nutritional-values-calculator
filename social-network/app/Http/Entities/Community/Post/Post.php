<?php

namespace App\Http\Entities\Community\Post;

use App\Http\Entities\MainEntity;

class Post extends MainEntity
{
    public ?int $id;
    public ?int $userId;
    public ?string $tableName;
    public ?int $tableId;
    public ?string $status = 'active';
    public ?string $createdAt;
    public ?string $updatedAt;
}
