<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'tag_category_id',
        'parent_tag_id',
        'color',
        'sort_order',
        'is_active',
        'metadata'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'metadata' => 'array'
    ];

    /**
     * Get the category this tag belongs to
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(TagCategory::class, 'tag_category_id');
    }

    /**
     * Get the parent tag
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'parent_tag_id');
    }

    /**
     * Get child tags
     */
    public function children(): HasMany
    {
        return $this->hasMany(Tag::class, 'parent_tag_id')->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get entities associated with this tag
     */
    public function entities(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class);
    }

    /**
     * Scope to get active tags
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get root tags (no parent)
     */
    public function scopeRoots($query)
    {
        return $query->whereNull('parent_tag_id');
    }

    /**
     * Get the full hierarchical name
     */
    public function getFullNameAttribute(): string
    {
        if ($this->parent) {
            return $this->parent->full_name . ' > ' . $this->name;
        }
        return $this->name;
    }
}
