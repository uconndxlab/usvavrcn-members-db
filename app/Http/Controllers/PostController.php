<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display posts for a specific group
     */
    public function index(Request $request, Entity $group)
    {
        // Ensure this is actually a group
        if ($group->entity_type !== 'group') {
            abort(404);
        }

        $posts = $group->groupPosts()
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('posts.index', compact('group', 'posts'));
    }

    /**
     * Show form to create a new post in a group
     */
    public function create(Entity $group)
    {
        if ($group->entity_type !== 'group') {
            abort(404);
        }

        return view('posts.create', compact('group'));
    }

    /**
     * Store a new post
     */
    public function store(Request $request, Entity $group)
    {
        if ($group->entity_type !== 'group') {
            abort(404);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:5000',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after:start_time',
            'author_id' => 'required|exists:entities,id'
        ]);

        Post::create([
            'entity_id' => $validated['author_id'],
            'target_group_id' => $group->id,
            'content' => $validated['content'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time']
        ]);

        return redirect()->route('groups.index')
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display all public posts (not targeted to specific groups)
     */
    public function publicPosts()
    {
        $posts = Post::public()
            ->with(['author', 'targetGroup'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('posts.public', compact('posts'));
    }
}
