<?php

namespace App\Http\Controllers;

use App\Models\SitePage;

class PublicPageController extends Controller
{
    /**
     * Show the home page.
     */
    public function home()
    {
        $page = SitePage::where('slug', 'home')->where('is_published', true)->first();
        if (!$page) {
            return view('public.home'); // fallback to static
        }
        return view('public.dynamic', [
            'page' => $page,
            'isHome' => true,
        ]);
    }

    /**
     * Show a dynamic page by slug.
     */
    public function show(string $slug)
    {
        $page = SitePage::where('slug', $slug)->where('is_published', true)->first();
        if (!$page) {
            abort(404);
        }
        return view('public.dynamic', [
            'page' => $page,
            'isHome' => false,
        ]);
    }
}
