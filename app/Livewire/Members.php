<?php

namespace App\Livewire;

use App\Models\Entity;
use App\Models\TagCategory;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Members extends Component
{
    public $members;
    public $tagCategories;

    // 
    public $selection = 'all';
    public $selectedTagIds = [];
    public $searchTerm = '';

    public function mount() {
        $this->refreshQuery();
        $this->tagCategories = TagCategory::with('tags')->get();
    }

    private function refreshQuery()
    {
        $query = Entity::where('entity_type', 'person');
        
        // update query
        if ($this->selection != 'all') {
            foreach ($this->selectedTagIds as $tagId => $value) {
                $query->whereHas('tags', function($q) use ($tagId) {
                    $q->where('tags.id', $tagId);
                });
            }
        }

        if ($this->searchTerm) {
            $query->where(function($q) {
                $q->where('name', 'like', "%{$this->searchTerm}%")
                    ->orWhere('first_name', 'like', "%{$this->searchTerm}%")
                    ->orWhere('last_name', 'like', "%{$this->searchTerm}%")
                    ->orWhere('company', 'like', "%{$this->searchTerm}%")
                    ->orWhere('email', 'like', "%{$this->searchTerm}%");
            });
        }

        $this->members = $query->with(['tags', 'tags.category'])->get();
    }

    public function updatedSelection() {
        if ($this->selection != "all") {
            if (!isset($this->selectedTagIds[$this->selection])) {
                $this->selectedTagIds[$this->selection] = true;
            }
        } else {
            // selecting all will deselect all tags
            $this->selectedTagIds = [];
        }

        $this->refreshQuery();
    }

    public function updatedSearchTerm()
    {
        $this->refreshQuery();
    }

    public function removeTag($tagId)
    {
        unset($this->selectedTagIds[$tagId]);
        $this->refreshQuery();
    }

    public function render()
    {

        return view('livewire.members', [
            'members' => $this->members,
            'tagCategories' => $this->tagCategories,
        ]);
    }
}