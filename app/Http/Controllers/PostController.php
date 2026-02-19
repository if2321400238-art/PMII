<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function indexBerita(Request $request)
    {
        $query = Post::berita()->published()->with(['author', 'category']);

        // Filter
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by author (using author_id + author_type for polymorphic)
        if ($request->has('author') && $request->author) {
            // Format: "type:id" e.g. "App\Models\User:1" or just "id" for backward compatibility
            $authorParam = $request->author;
            if (str_contains($authorParam, ':')) {
                [$type, $id] = explode(':', $authorParam);
                $query->where('author_type', $type)->where('author_id', $id);
            } else {
                // Backward compatibility: assume User type
                $query->where('author_id', $authorParam);
            }
        }

        if ($request->has('sort')) {
            if ($request->sort === 'populer') {
                $query->orderBy('view_count', 'desc');
            } elseif ($request->sort === 'terbaru') {
                $query->latest('published_at');
            }
        } else {
            $query->latest('published_at');
        }

        $posts = $query->paginate(12)->withQueryString();
        $categories = \App\Models\Category::whereHas('posts', function ($q) {
            $q->berita()->published();
        })->get();
        $popularPosts = Post::berita()
            ->published()
            ->with(['author', 'category'])
            ->orderByDesc('view_count')
            ->orderByDesc('published_at')
            ->take(6)
            ->get();
        $leftAd = Ad::active()
            ->where('position', 'berita_left')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->first();

        // Get unique authors from published berita posts (supports polymorphic)
        $authors = Post::berita()->published()
            ->select('author_id', 'author_type')
            ->distinct()
            ->get()
            ->map(function ($post) {
                $author = $post->author;
                if ($author) {
                    return (object) [
                        'id' => $post->author_type . ':' . $post->author_id,
                        'name' => $author->name,
                    ];
                }
                return null;
            })
            ->filter()
            ->unique('name')
            ->values();

        return view('frontend.rubrik.berita', compact('posts', 'categories', 'authors', 'popularPosts', 'leftAd'));
    }



    public function show(Post $post)
    {
        if ($post->published_at === null) {
            abort(404);
        }

        $post->increment('view_count');

        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->published()
            ->latest('published_at')
            ->take(3)
            ->with(['author', 'category'])
            ->get();

        return view('frontend.post.show', compact('post', 'relatedPosts'));
    }
}
