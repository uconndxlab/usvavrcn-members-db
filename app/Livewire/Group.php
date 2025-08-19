<?php

namespace App\Livewire;

use App\Models\Entity;
use Livewire\Component;

class Group extends Component
{

    public $group;
    public $selectedTab = "members"; // members|forum

    public function mount(Entity $group) {
        $this->group = $group;
    }

    public function render()
    {
        return view('livewire.group', [
            'group' => $this->group,
        ]);
    }
}