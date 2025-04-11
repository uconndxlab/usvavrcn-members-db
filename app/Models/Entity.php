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

    
}
