<?php

namespace App\Http\Controllers;
use App\Models\Tag;

use Illuminate\Http\Request;

class TagController extends Controller

{
    public function index()
    {
        $tags = Tag::orderBy('name')->get();
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tags,name|max:255',
        ]);

        Tag::create(['name' => $request->name]);

        return redirect()->route('tags.index')->with('success', 'Tag created!');
    }

    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|max:255|unique:tags,name,' . $tag->id,
        ]);

        $tag->update(['name' => $request->name]);

        return redirect()->route('tags.index')->with('success', 'Tag updated!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('tags.index')->with('success', 'Tag deleted!');
    }
}
