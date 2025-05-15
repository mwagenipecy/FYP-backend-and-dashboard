<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'status',
        'notes',
    ];

    // Relationships
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeRegistered($query)
    {
        return $query->where('status', 'registered');
    }

    public function scopeAttended($query)
    {
        return $query->where('status', 'attended');
    }

    // Accessors
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'registered' => 'blue',
            'attended' => 'green',
            'cancelled' => 'red',
            default => 'gray'
        };
    }
}
