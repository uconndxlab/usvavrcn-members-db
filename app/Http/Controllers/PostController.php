<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display posts for a specific group
     */
    public function index(Request $request, Entity $group)
    {

        // Redirect to new version of this page
        return redirect()->route('groups.show', $group);

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
     * Display specific post in a group
     */
    public function show(Entity $group, Post $post)
    {
        // Ensure this is actually a group
        if ($group->entity_type !== 'group') {
            abort(404);
        }

        return view('posts.show', compact('group', 'post'));
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

        $user = Auth::user();

        if (!$user->entity) {
            return redirect()->back()->withErrors('You must have an entity to create posts.');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:5000',
            'title' => 'required|string|max:60',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after:start_time',
        ]);

        Post::create([
            'entity_id' => $user->entity->id,
            'target_group_id' => $group->id,
            'content' => $validated['content'],
            'title' => $validated['title'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);

        return redirect()->route('groups.show', $group)
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
