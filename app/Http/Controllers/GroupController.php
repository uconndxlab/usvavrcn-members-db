<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\TagCategory;
use Illuminate\Http\Request;

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
}
