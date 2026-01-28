<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('author', 'category');

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        $posts = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:berita,pena_santri',
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|max:2048',
            'is_popular' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['author_id'] = auth()->id();
        
        // Set published_at to now if not provided
        if (!isset($validated['published_at']) || !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil dibuat');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'type' => 'required|in:berita,pena_santri',
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|max:2048',
            'is_popular' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil diperbarui');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil dihapus');
    }
}
