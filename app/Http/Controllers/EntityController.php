<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entity;
use App\Models\TagCategory;
use Illuminate\Support\Facades\Gate;

class EntityController extends Controller
{
    public function index(Request $request)
    {

        // redirect to /members
        return redirect()->route('members.index');


        $query = Entity::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
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
        $tagCategories = TagCategory::active()->ordered()->with('activeTags')->get();
        $allPeople = Entity::where('entity_type', 'person')
            ->where('name', '!=', '')
            ->orderBy('name')
            ->get();
        $selectedTags = [];
        $selectedMembers = [];
        
        return view('entities.create', compact('tagCategories', 'allPeople', 'selectedTags', 'selectedMembers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'entity_type' => 'required|in:person,group',
            'name' => 'nullable|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255', 
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'biography' => 'nullable|string',
            'job_title' => 'nullable|string',
            'company' => 'nullable|string',
            'career_stage' => 'nullable|string',
            'affiliation' => 'nullable|string',
            'funding_sources' => 'nullable|string',
            'primary_institution_name' => 'nullable|string',
            'website' => 'nullable|url',
            'research_interests' => 'nullable|string',
            'projects' => 'nullable|string',
            'photo_src' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'members' => 'nullable|array',
            'members.*' => 'exists:entities,id'
        ]);

        // Set name based on first/last name if provided
        if (empty($validated['name']) && !empty($validated['first_name']) && !empty($validated['last_name'])) {
            $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];
        }

        $entity = Entity::create($validated);
        
        // Sync tags
        if ($request->has('tags')) {
            $entity->tags()->sync($request->input('tags', []));
        }

        // Sync group members if this is a group
        if ($entity->entity_type === 'group' && $request->has('members')) {
            $entity->members()->sync($request->input('members', []));
        }

        return redirect()->route('entities.index')->with('success', 'Entity created.');
    }

    public function show(Entity $entity)
    {
        $tagCategories = TagCategory::active()->ordered()->with('activeTags')->get();
        $selectedTags = $entity->tags->pluck('id')->toArray();
        $allPeople = Entity::where('entity_type', 'person')->orderBy('name')->get();
        $selectedMembers = $entity->members->pluck('id')->toArray();
        
        // return view('entities.show', compact('entity', 'tagCategories', 'selectedTags', 'allPeople', 'selectedMembers'));
        return view('entities.show2', compact('entity', 'tagCategories', 'selectedTags', 'allPeople', 'selectedMembers'));
    }

    public function edit(Entity $entity)
    {
        if (!Gate::allows('edit-member', $entity)) {
            abort(403);
        }

        $tagCategories = TagCategory::active()->ordered()->with('activeTags')->get();
        $selectedTags = $entity->tags->pluck('id')->toArray();
        $allPeople = Entity::where('entity_type', 'person')
            ->where('name', '!=', '')
            ->orderBy('name')
            ->get();

        $selectedMembers = $entity->members->pluck('id')->toArray();
        
        return view('entities.edit', compact('entity', 'tagCategories', 'selectedTags', 'allPeople', 'selectedMembers'));
    }

    public function update(Request $request, Entity $entity)
    {
        if (!Gate::allows('edit-member', $entity)) {
            abort(403);
        }

        $validated = $request->validate([
            'entity_type' => 'required|in:person,group',
            'name' => 'nullable|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'biography' => 'nullable|string',
            'job_title' => 'nullable|string',
            'company' => 'nullable|string',
            'career_stage' => 'nullable|string',
            'affiliation' => 'nullable|string',
            'funding_sources' => 'nullable|string',
            'primary_institution_name' => 'nullable|string',
            'website' => 'nullable|url',
            'research_interests' => 'nullable|string',
            'projects' => 'nullable|string',
            'photo_src' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'members' => 'nullable|array',
            'members.*' => 'exists:entities,id'
        ]);

        // Set name based on first/last name if provided
        if (empty($validated['name']) && !empty($validated['first_name']) && !empty($validated['last_name'])) {
            $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];
        }

        $entity->update($validated);

        // Sync tags
        $entity->tags()->sync($request->input('tags', []));

        // Sync group members if this is a group
        if ($entity->entity_type === 'group') {
            $entity->members()->sync($request->input('members', []));
        }

        if ($entity->entity_type === 'group') {
            return redirect()->route('groups.show', $entity)->with('success', 'Entity updated.');
        } else {
            return redirect()->route('members.show', $entity)->with('success', 'Entity updated.');
        }
    }

    public function destroy(Entity $entity)
    {
        $entity->delete();
        return redirect()->route('entities.index')->with('success', 'Entity deleted.');
    }
}
