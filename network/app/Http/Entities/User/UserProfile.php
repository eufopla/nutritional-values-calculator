<?php

namespace App\Http\Entities\User;

use App\Http\Entities\MainEntity;

class UserProfile extends MainEntity
{
    public ?int $id = null;
    public ?int $userId = null;
    public ?string $userName = null;
    public ?string $profilePicture = null;
    public ?string $biography = null;
    public ?string $updatedAt = null;
}
