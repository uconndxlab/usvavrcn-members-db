<?php

namespace App\Livewire;

use App\Models\Entity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Group extends Component
{

    public $group;
    public $selectedTab = "members"; // members|forum

    public function mount(Entity $group) {
        $this->group = $group;
    }

    public function updatedSelectedTab($tab)
    {
        if ($tab === 'forum') {
            // update read posts pivot table
            $user = Auth::user();
            $user->posts()->syncWithoutDetaching($this->group->groupPosts->pluck('id'));

            $count = 0;
            $user->entity->groups->each(function ($group) use ($user, &$count) {
                $group->groupPosts->each(function ($post) use ($user, &$count) {
                    if (!$user->posts->contains($post->id)) {
                        $count++;
                    }
                });
            });

            // tell browser component to dispatch another browser event up the dom
            // to tell the navbar to update the unread posts count
            $this->dispatch('unread-posts-updated', count: $count);
        }
    }

    public function render()
    {
        return view('livewire.group', [
            'group' => $this->group,
        ]);
    }
}