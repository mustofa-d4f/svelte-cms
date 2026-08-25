<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['author', 'category', 'tags'])
            ->where('status', 'published')
            ->where('published_at', '<=', now());

        if ($request->has('category') && $request->category !== '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('tag') && $request->tag !== '') {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->latest('published_at')->paginate(12)->withQueryString();

        return Inertia::render('public/Archive', [
            'posts' => $posts,
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
            'filters' => $request->only(['category', 'tag', 'search']),
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::with(['author', 'category', 'tags'])
            ->where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        $post->increment('views');

        $relatedPosts = Post::with(['author', 'category'])
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return Inertia::render('public/posts/Show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ]);
    }
}
