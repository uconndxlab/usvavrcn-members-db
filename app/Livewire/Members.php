<?php

namespace App\Livewire;

use App\Models\Entity;
use App\Models\TagCategory;
use Livewire\Component;
use Livewire\WithPagination;

class Members extends Component
{
    use WithPagination;
    
    public $tagCategories;

    // 
    public $selection = 'all';
    public $selectedTagIds = [];
    public $searchTerm = '';

    public function mount() {
        $this->tagCategories = TagCategory::with('tags')->get();
    }

    private function getQuery()
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

        return $query->with(['tags', 'tags.category']);
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

        $this->resetPage();
    }

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function removeTag($tagId)
    {
        unset($this->selectedTagIds[$tagId]);
        $this->resetPage();
    }

    public function render()
    {
        $members = $this->getQuery()->paginate(15);

        return view('livewire.members', [
            'members' => $members,
            'tagCategories' => $this->tagCategories,
        ]);
    }
}