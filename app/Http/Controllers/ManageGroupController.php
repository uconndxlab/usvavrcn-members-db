<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Tag;

use Illuminate\Http\Request;

class ManageGroupController extends Controller

{
    public function index()
    {
        $groups = Entity::where('entity_type', 'group')->get();
        return view('admin.groups.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.groups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:entities,name|max:255',
        ]);

        Entity::create([
            'name' => $request->name,
            'entity_type' => 'group'
        ]);

        return redirect()->route('groups.index')->with('success', 'Group created!');

    }

    public function edit(Entity $group)
    {
        return view('admin.groups.edit', compact('group'));
    }

    public function update(Request $request, Entity $group)
    {
        $request->validate([
            'name' => 'required|max:255|unique:entities,name,' . $group->id,
        ]);

        $group->update(['name' => $request->name]);

        return redirect()->route('groups.index')->with('success', 'Group updated!');

    }

    public function destroy(Entity $group)
    {
        $group->delete();
        return redirect()->route('groups.index')->with('success', 'Group deleted!');
    }
}
