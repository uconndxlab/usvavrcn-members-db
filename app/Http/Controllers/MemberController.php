<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\TagCategory;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {        
        return view('members.index');
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
