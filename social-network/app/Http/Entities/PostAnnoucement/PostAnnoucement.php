<?php

namespace App\Http\Entities\PostAnnoucement;

use App\Http\Entities\MainEntity;

class PostAnnoucement extends MainEntity
{
    public ?int $id;
    public ?string $content;
    public ?string $title;
    public ?string $beginDate;
    public ?string $endDate;
}