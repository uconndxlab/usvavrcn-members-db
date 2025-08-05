<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'entity_id',
        'target_group_id', 
        'content',
        'start_time',
        'end_time'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];

    /**
     * The author of the post
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }

    /**
     * The group this post is targeted to (if any)
     */
    public function targetGroup(): BelongsTo
    {
        return $this->belongsTo(Entity::class, 'target_group_id');
    }

    /**
     * Scope for posts in a specific group
     */
    public function scopeInGroup($query, $groupId)
    {
        return $query->where('target_group_id', $groupId);
    }

    /**
     * Scope for public posts (not targeted to specific group)
     */
    public function scopePublic($query)
    {
        return $query->whereNull('target_group_id');
    }
}
