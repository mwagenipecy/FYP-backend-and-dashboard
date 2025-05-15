<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\PostComment;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'excerpt',
        'type',
        'status',
        'featured_image',
        'images',
        'tags',
        'event_date',
        'event_time',
        'event_location',
        'max_participants',
        'requirements',
        'is_featured',
        'allow_comments',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'images' => 'array',
        'tags' => 'array',
        'event_date' => 'date',
        //'event_time' => 'time',
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',
    ];

    // Relationships
    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class)->where('parent_id', null);
    }

    public function allComments()
    {
        
        return $this->hasMany(PostComment::class);
    }

    public function participants()
    {
        return $this->hasMany(PostParticipant::class);
    }

    public function activeParticipants()
    {
        return $this->participants()->where('status', 'registered');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Accessors & Mutators
    public function getExcerptAttribute($value)
    {
        return $value ?: Str::limit(strip_tags($this->content), 150);
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->title);
    }

    public function getFormattedPublishedDateAttribute()
    {
        return $this->published_at?->format('M d, Y');
    }

    public function getEventDateTimeAttribute()
    {
        if ($this->event_date && $this->event_time) {
            return $this->event_date->format('M d, Y') . ' at ' . $this->event_time->format('g:i A');
        }
        return $this->event_date?->format('M d, Y');
    }

    public function getParticipantCountAttribute()
    {
        return $this->activeParticipants()->count();
    }

    public function getSpotsRemainingAttribute()
    {
        if (!$this->max_participants) return null;
        return max(0, $this->max_participants - $this->participant_count);
    }

    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'blog' => 'blue',
            'event' => 'green',
            'activity' => 'purple',
            default => 'gray'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'published' => 'green',
            'draft' => 'yellow',
            'archived' => 'gray',
            default => 'gray'
        };
    }

    // Methods
    public function canUserParticipate($user = null)
    {
        if (!$user) return false;
        
        // Check if event has space
        if ($this->max_participants && $this->participant_count >= $this->max_participants) {
            return false;
        }

        // Check if user is already registered
        return !$this->participants()->where('user_id', $user->id)->exists();
    }

    public function registerParticipant($user, $notes = null)
    {
        if (!$this->canUserParticipate($user)) {
            return false;
        }

        return $this->participants()->create([
            'user_id' => $user->id,
            'notes' => $notes,
            'status' => 'registered'
        ]);
    }
}