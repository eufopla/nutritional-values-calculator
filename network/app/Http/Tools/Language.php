<?php

namespace App\Http\Tools;

use App\Http\Models\Application\Schema;
use App\Http\Models\MainModel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Language extends MainModel
{
    public static function setLanguage(string|null $locale = null): void {
        if ($locale !== null && in_array($locale, config('language.available_locales'))) {
            App::setLocale($locale);
        } elseif(config('language.locale') !== null) {
            App::setLocale(config('language.locale'));
        } else {
            App::setLocale(config('language.fallback_locale'));
        }
    }

}
