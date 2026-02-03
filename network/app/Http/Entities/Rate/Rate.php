<?php

namespace App\Http\Entities\Rate;

use App\Http\Entities\MainEntity;

class Rate extends MainEntity
{
    public ?int $id;
    public ?int $rate;
    public ?int $userId;
    public ?int $targetUserId;
    public ?string $targetTableName;
    public ?int $targetTableId;
    public ?string $createdAt;
    public ?string $updatedAt;
}