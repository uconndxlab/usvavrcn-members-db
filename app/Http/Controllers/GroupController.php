<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\TagCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $query = Entity::where('entity_type', 'group');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Tag filtering
        if ($request->has('tag') && $request->tag) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }
        
        $groups = $query->with(['tags', 'tags.category', 'members'])->get();
        $tagCategories = TagCategory::with('tags')->get();
        
        return view('groups.index', compact('groups', 'tagCategories'));
    }
    
    public function show(Entity $group)
    {
        if ($group->entity_type !== 'group') {
            abort(404);
        }
        
        $group->load(['tags', 'tags.category', 'members', 'posts']);
        
        return view('groups.show', compact('group'));
    }

    public function join(Entity $group)
    {
        if ($group->entity_type !== 'group') {
            abort(404);
        }

        $user = Auth::user();
        
        if (!$user->entity) {
            return redirect()->route('groups.show', $group)->with('error', 'Your user does not have an entity!');
        }

        if ($group->members()->where('entity_id', $user->entity->id)->exists()) {
            return redirect()->route('groups.show', $group)->with('info', 'You are already a member of this group!');
        }

        $group->members()->attach($user->entity->id);

        return redirect()->route('groups.show', $group)->with('success', 'You have successfully joined the group.');
    }

    public function leave(Entity $group)
    {
        if ($group->entity_type !== 'group') {
            abort(404);
        }

        $user = Auth::user();
        
        if (!$user->entity) {
            return redirect()->route('groups.show', $group)->with('error', 'Profile not found.');
        }

        $group->members()->detach($user->entity->id);

        return redirect()->route('groups.show', $group)->with('success', 'You have left the group successfully.');
    }

    public function removeMember(Entity $group, Entity $member)
    {
        if ($group->entity_type !== 'group') {
            abort(404);
        }

        $user = Auth::user();

        if (!$user->entity) {
            return redirect()->route('groups.show', $group)->with('error', 'Profile not found.');
        }

        if (!Auth::user()->is_admin) {
            return redirect()->route('groups.show', $group)->with('error', 'You do not have permission to remove members.');
        }

        if (!$group->members()->where('entity_id', $member->id)->exists()) {
            return redirect()->route('groups.show', $group)->with('info', 'The specified member is not part of this group.');
        }

        $group->members()->detach($member->id);

        return redirect()->route('groups.show', $group)->with('success', 'Member has been removed from the group successfully.');
    }
}
