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

    public function create()
    {
        return view('entities.create');
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
        return view('entities.show', compact('entity'));
    }

    public function edit(Entity $entity)
    {
        return view('entities.edit', compact('entity'));
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
        return redirect()->route('entities.index')->with('success', 'Entity updated.');
    }

    public function destroy(Entity $entity)
    {
        $entity->delete();
        return redirect()->route('entities.index')->with('success', 'Entity deleted.');
    }
}
