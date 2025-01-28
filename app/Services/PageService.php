<?php

namespace App\Services;

use App\Models\Page;

class PageService
{
    public static function getPages(): mixed
    {
        $pages = Page::orderByDesc('id')->get();

        return $pages;
    }

    public static function findPageBySlug($slug): ?Page
    {
        return Page::where('slug', $slug)->firstOrFail();
    }
}
