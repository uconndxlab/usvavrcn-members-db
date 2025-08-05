<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TagCategory extends Model
{
    protected $fillable = [
        'name',
        'slug', 
        'description',
        'color',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the tags for this category
     */
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class)->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get active tags for this category
     */
    public function activeTags(): HasMany
    {
        return $this->tags()->where('is_active', true);
    }

    /**
     * Scope to get active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
