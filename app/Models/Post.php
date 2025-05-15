<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function author()
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }

    public function group()
    {
        return $this->belongsTo(Entity::class, 'target_group_id');
    }
}
