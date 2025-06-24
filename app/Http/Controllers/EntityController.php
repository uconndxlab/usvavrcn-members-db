<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entity;

class EntityController extends Controller
{
    public function index(Request $request)
    {
        $query = Entity::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->where('entity_type', $request->type);
        }

        if ($request->filled('sort')) {
            $direction = $request->sort === 'name_desc' ? 'desc' : 'asc';
            $query->orderBy('name', $direction);
        }

        $entities = $query->paginate(12)->withQueryString();

        return view('entities.index', compact('entities'));
    }

    public function create(Entity $entity)
    {
        return view('entities.create', compact('entity'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'entity_type' => 'required|in:person,group',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            // Add more validations as needed
        ]);

        Entity::create($validated);
        return redirect()->route('entities.index')->with('success', 'Entity created.');
    }

    public function show(Entity $entity)
    {
        $tags = \App\Models\Tag::orderBy('name')->get(); // pass in all available tags
        $selectedTags = $entity->tags->pluck('id')->toArray();
        $allPeople = Entity::where('entity_type', 'person')->orderBy('name')->get();

        $selectedMembers = $entity->members->pluck('id')->toArray();
        return view('entities.show', compact('entity', 'tags', 'selectedTags', 'allPeople', 'selectedMembers'));
    }

    public function edit(Entity $entity)
    {
        $tags = \App\Models\Tag::orderBy('name')->get(); // pass in all available tags
        $selectedTags = $entity->tags->pluck('id')->toArray();
        $allPeople = Entity::where('entity_type', 'person')
            ->where('name', '!=', '')
            ->orderBy('name')
            ->get();


        $selectedMembers = $entity->members->pluck('id')->toArray();
        return view('entities.edit', compact('entity', 'tags', 'selectedTags', 'allPeople', 'selectedMembers'));
    }

    public function update(Request $request, Entity $entity)
    {
        $validated = $request->validate([
            'entity_type' => 'required|in:person,group',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            // Add more validations as needed
        ]);

        $entity->update($validated);

        $entity->tags()->sync($request->input('tags', []));

        if ($entity->entity_type === 'group') {
            $entity->members()->sync($request->input('members', []));
        }

        return redirect()->route('entities.show', $entity)->with('success', 'Entity updated.');
    }

    public function destroy(Entity $entity)
    {
        $entity->delete();
        return redirect()->route('entities.index')->with('success', 'Entity deleted.');
    }
}
