<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\TagCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
        
        $member->load(['tags', 'tags.category']);
        
        return view('members.show', compact('member'));
    }

    public function toggleAdmin(Entity $member)
    {
        if (!Gate::allows('admin')) {
            abort(403);
        }

        $user = User::where('entity_id', $member->id)->first();

        if (!$user) {
            return redirect()->route('members.show', $member)->with('error', 'This member does not have a user account!');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        return redirect()->back()->with('status', $user->is_admin ? 'Admin access granted.' : 'Admin access revoked.');
    }

    public function afterRegistration()
    {
        return view('auth.after-registration');
    }
}
