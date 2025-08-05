<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\TagCategory;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Entity::where('entity_type', 'person');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Tag filtering
        if ($request->has('tag') && $request->tag) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }
        
        $members = $query->with(['tags', 'tags.category'])->paginate(20);
        $tagCategories = TagCategory::with('tags')->get();
        
        return view('members.index', compact('members', 'tagCategories'));
    }
    
    public function show(Entity $member)
    {
        if ($member->entity_type !== 'person') {
            abort(404);
        }
        
        $member->load(['tags', 'tags.category', 'memberOf']);
        
        return view('members.show', compact('member'));
    }
}
