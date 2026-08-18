<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'entity_id',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login' => 'datetime',
        ];
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    /**
     * Find or create the login account for a person entity, matched by email.
     * Returns null for entities with no email or that aren't a person (e.g. groups).
     */
    public static function createForEntity(Entity $entity): ?self
    {
        if ($entity->entity_type !== 'person' || empty($entity->email)) {
            return null;
        }

        return static::firstOrCreate(
            ['email' => $entity->email],
            [
                'name' => $entity->name,
                'entity_id' => $entity->id,
                'password' => Hash::make(Str::random(16)),
            ]
        );
    }

    /**
     * Update the last login date for the user.
     */
    public function updateLastLogin()
    {
        $this->last_login = now();
        $this->save();
    }

    /**
     * Get the posts that the user has read.
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_reads')->withTimestamps();
    }
}
