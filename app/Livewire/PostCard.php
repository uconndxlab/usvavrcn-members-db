<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Entity;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PostCard extends Component
{

    public Post $post;
    public Entity $group;
    public bool $commentsEnabled = false;
    public bool $isCommenting = false;
    public string $comment = '';

    protected $rules = [
        'comment' => 'string|max:5000',
    ];
    
    public function mount(Post $post, Entity $group)
    {
        $this->post = $post;
        $this->group = $group;

        if ($this->post->parent_id == null) {
            $this->commentsEnabled = true;
        }
    }

    public function render()
    {
        return view('livewire.post-card', [
            'post' => $this->post,
            'group' => $this->group
        ]);
    }

    public function startCommenting()
    {
        $this->isCommenting = true;
    }

    public function stopCommenting()
    {
        $this->comment = '';
        $this->isCommenting = false;
    }

    public function postComment()
    {
        $this->comment = trim($this->comment);
        if (empty($this->comment)) {
            return;
        }

        Post::create([
            'entity_id' => Auth::user()->entity->id,
            'target_group_id' => $this->group->id,
            'content' => $this->comment,
            'parent_id' => $this->post->id
        ]);

        $this->stopCommenting();
    }
}