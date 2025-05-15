<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function entities()
    {
        return $this->belongsToMany(Entity::class);
    }
}
