<?php

namespace App\Http\Entities\Community\PostAnnoucement;

use App\Http\Entities\MainEntity;

class PostAnnoucement extends MainEntity
{
    public ?int $id;
    public ?string $content;
    public ?string $title;
    public ?string $theme;
    public ?string $beginDate;
    public ?string $endDate;
}