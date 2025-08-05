<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Entity extends Model
{
    protected $fillable = [
        'entity_type',
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'description',
        'biography',
        'coe_affiliation',
        'affiliation',
        'lab_group',
        'company',
        'research_interests',
        'expertise',
        'projects',
        'publications',
        'awards',
        'funding_sources',
        'creation_date',
        'last_updated',
        'linkedin',
        'website',
        'social_links',
        'job_title',
        'career_stage',
        'primary_institution_name',
        'primary_institution_department',
        'primary_institution_mailing',
        'secondary_institution_name',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'photo_src',
        'is_public',
        'allow_contact',
        'status',
        'profile_completed_at'
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'allow_contact' => 'boolean',
        'social_links' => 'array',
        'creation_date' => 'datetime',
        'last_updated' => 'datetime',
        'profile_completed_at' => 'datetime'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get tags by category
     */
    public function tagsByCategory(string $categorySlug): BelongsToMany
    {
        return $this->tags()->whereHas('category', function ($query) use ($categorySlug) {
            $query->where('slug', $categorySlug);
        });
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Posts targeted to this group (if this entity is a group)
     */
    public function groupPosts(): HasMany
    {
        return $this->hasMany(Post::class, 'target_group_id');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class, 'entity_group', 'entity_id', 'group_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class, 'entity_group', 'group_id', 'entity_id');
    }

    /**
     * Scope for people only
     */
    public function scopePeople($query)
    {
        return $query->where('entity_type', 'person');
    }

    /**
     * Scope for groups only  
     */
    public function scopeGroups($query)
    {
        return $query->where('entity_type', 'group');
    }

    /**
     * Scope for active entities
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for public profiles
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Get full name for people
     */
    public function getFullNameAttribute(): string
    {
        if ($this->entity_type === 'person' && $this->first_name && $this->last_name) {
            return $this->first_name . ' ' . $this->last_name;
        }
        return $this->name;
    }

    /**
     * Check if profile is complete
     */
    public function getIsProfileCompleteAttribute(): bool
    {
        $requiredFields = ['name', 'email', 'description'];
        
        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }
        
        return true;
    }
}
