<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'hub_id',
        'name',
        'description',
        'link',
        'issue_date',
        'end_date',
        'created_by',
        'type',
        'user_id',
        'project_id',
        'activity_type',
        'registration_start',
        'registration_end',
        'max_participants',
        'auto_approve',
        'requires_approval',
        'instructions',
        'is_active',
    ];

    protected $casts = [
        'issue_date' => 'datetime',
        'end_date' => 'datetime',
        'registration_start' => 'datetime',
        'registration_end' => 'datetime',
        'auto_approve' => 'boolean',
        'requires_approval' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function hub(): BelongsTo
    {
        return $this->belongsTo(Hub::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // public function questions(): BelongsToMany
    // {
    //     return $this->belongsToMany(DynamicQuestion::class, 'activity_questions')
    //                 ->withPivot('display_order', 'is_required')
    //                 ->orderBy('activity_questions.display_order');
    // }

    public function questions()
    {
        return $this->belongsToMany(DynamicQuestion::class, 'activity_questions', 'activity_id', 'question_id')
                    ->withPivot(['display_order', 'is_required'])
                    ->orderBy('activity_questions.display_order');
    }
    



    public function participants(): HasMany
    {
        return $this->hasMany(ActivityParticipant::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(QuestionAnswer::class);
    }

    public function approvedParticipants(): HasMany
    {
        return $this->hasMany(ActivityParticipant::class)->where('status', 'approved');
    }

    public function pendingParticipants(): HasMany
    {
        return $this->hasMany(ActivityParticipant::class)->where('status', 'pending');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('activity_type', $type);
    }

    public function scopeRegistrationOpen($query)
    {
        return $query->where('registration_start', '<=', now())
                    ->where('registration_end', '>=', now());
    }

    // Helper methods
    public function isRegistrationOpen(): bool
    {
        if (!$this->registration_start || !$this->registration_end) {
            return true;
        }

        return now()->between($this->registration_start, $this->registration_end);
    }

    public function hasAvailableSlots(): bool
    {
        if (!$this->max_participants) {
            return true;
        }

        return $this->approvedParticipants()->count() < $this->max_participants;
    }

    public function canUserParticipate(User $user): bool
    {
        return $this->isRegistrationOpen() 
            && $this->hasAvailableSlots() 
            && !$this->participants()->where('user_id', $user->id)->exists();
    }
}