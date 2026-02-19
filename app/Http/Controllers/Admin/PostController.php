<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\AuthHelper;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Post::with('author', 'category', 'approvedBy');

        // Get current user from any guard
        $currentUser = AuthHelper::user();
        $userType = AuthHelper::userType();

        // Filter: non-admin hanya lihat postingan sendiri
        if ($userType !== 'user' || $currentUser->role_slug !== 'admin') {
            $query->where('author_id', $currentUser->id)
                  ->where('author_type', get_class($currentUser));
        }

        if ($request->has('approval_status') && $request->approval_status) {
            $query->where('approval_status', $request->approval_status);
        }

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
            'type' => 'required|in:berita',
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|max:2048',
            'thumbnail_caption' => 'nullable|string|max:500',
            'is_popular' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        // Generate unique slug
        $slug = Str::slug($validated['title']);
        $count = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = Str::slug($validated['title']) . '-' . $count;
            $count++;
        }
        $validated['slug'] = $slug;

        // Set author dengan polymorphic relation
        $currentUser = AuthHelper::user();
        $validated['author_id'] = $currentUser->id;
        $validated['author_type'] = get_class($currentUser);

        // Set approval status: admin langsung approved, lainnya pending
        $userType = AuthHelper::userType();
        $isAdmin = $userType === 'user' && $currentUser->role_slug === 'admin';

        if ($isAdmin) {
            $validated['approval_status'] = 'approved';
            $validated['approved_by'] = $currentUser->id;
            $validated['approved_at'] = now();
        } else {
            $validated['approval_status'] = 'pending';
        }

        // Set published_at to now if not provided
        if (!isset($validated['published_at']) || !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        Post::create($validated);

        $message = $validated['approval_status'] === 'pending'
            ? 'Post berhasil dibuat dan menunggu persetujuan admin'
            : 'Post berhasil dibuat dan dipublikasikan';

        return redirect()->route('admin.posts.index')->with('success', $message);
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
            'thumbnail_caption' => 'nullable|string|max:500',
            'is_popular' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        // Generate unique slug only if title changed
        if ($post->title !== $validated['title']) {
            $slug = Str::slug($validated['title']);
            $count = 1;
            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = Str::slug($validated['title']) . '-' . $count;
                $count++;
            }
            $validated['slug'] = $slug;
        }

        // Reset approval status jika post ditolak dan di-update
        if ($post->approval_status === 'rejected') {
            $currentUser = AuthHelper::user();
            $userType = AuthHelper::userType();
            $isAdmin = $userType === 'user' && $currentUser->role_slug === 'admin';

            if ($isAdmin) {
                $validated['approval_status'] = 'approved';
                $validated['approved_by'] = $currentUser->id;
                $validated['approved_at'] = now();
            } else {
                $validated['approval_status'] = 'pending';
                $validated['approved_by'] = null;
                $validated['approved_at'] = null;
            }
            $validated['rejection_reason'] = null;
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil diperbarui');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil dihapus');
    }

    public function approve(Post $post)
    {
        $this->authorize('approve', $post);

        $currentUser = AuthHelper::user();
        $post->update([
            'approval_status' => 'approved',
            'approved_by' => $currentUser->id,
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        return redirect()->back()->with('success', 'Post berhasil disetujui');
    }

    public function reject(Request $request, Post $post)
    {
        $this->authorize('reject', $post);

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $post->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()->back()->with('success', 'Post berhasil ditolak');
    }

    public function publish(Request $request, Post $post)
    {
        $validated = $request->validate([
            'published_at' => 'required|date',
        ]);

        $post->update([
            'published_at' => $validated['published_at'],
        ]);

        return redirect()->back()->with('success', 'Post berhasil dipublikasikan');
    }
}
