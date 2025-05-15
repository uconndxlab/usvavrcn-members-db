<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    protected $fillable = [
        'entity_type',
        'name',
        'email',
        'phone',
        'description',
        // Add more fields as needed
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Entity::class, 'entity_group', 'entity_id', 'group_id');
    }

    public function members()
    {
        return $this->belongsToMany(Entity::class, 'entity_group', 'group_id', 'entity_id');
    }
}
