<?php

namespace App\Http\Entities\PostFeedback;

use App\Http\Entities\MainEntity;

class PostFeedback extends MainEntity
{
    public ?int $id;
    public ?int $targetUserId;
    public ?int $rateId;
    public ?int $sessionId;
    public ?string $content;
}