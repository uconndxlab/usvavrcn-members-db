<?php

namespace App\Livewire;

use App\Models\Entity;
use App\Models\TagCategory;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Groups extends Component
{

    public $groups;
    public $tagCategories;

    //

    public $selectedGroup = "all";

    public function mount() {
        $query = Entity::where('entity_type', 'group');

        // Search functionality
        // if ($request->has('search') && $request->search) {
        //     $search = $request->search;
        //     $query->where(function($q) use ($search) {
        //         $q->where('name', 'like', "%{$search}%")
        //           ->orWhere('description', 'like', "%{$search}%");
        //     });
        // }

        // Tag filtering
        // if ($request->has('tag') && $request->tag) {
        //     $query->whereHas('tags', function($q) use ($request) {
        //         $q->where('tags.id', $request->tag);
        //     });
        // }

        $this->groups = $query->with(['tags', 'tags.category', 'members'])->get();
        $this->tagCategories = TagCategory::with('tags')->get();
    }

    // TODO: I'm not sure if groups have relations to group by category (eg: teams, focus, etc.)
    public function selectGroup($group)
    {
        $this->selectedGroup = $group;
        $query = Entity::where('entity_type', 'group');

        if ($this->selectedGroup != "all") {
            $query->whereHas('tags', function($q) {
                $q->where('tags.id', $this->selectedGroup);
            });
        }

        $this->groups = $query->with(['tags', 'tags.category', 'members'])->get();
    }

    public function render()
    {
        return view('livewire.groups', [
            'groups' => $this->groups,
            'tagCategories' => $this->tagCategories,
        ]);
    }
}