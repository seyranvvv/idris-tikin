<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    // GET /api/pages
    public function index()
    {
        return Page::where('is_published', true)->get();
    }

    // GET /api/pages/{slug}
    public function show($slug)
    {
        return Page::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
    }
}