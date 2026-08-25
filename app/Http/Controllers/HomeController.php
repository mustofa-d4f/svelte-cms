<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke()
    {
        $posts = Post::with(['author', 'category', 'tags'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(9)
            ->get();

        return Inertia::render('public/Home', [
            'posts' => $posts,
        ]);
    }
}
