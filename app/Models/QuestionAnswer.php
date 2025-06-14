<?php
// app/Models/QuestionAnswer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'student_name',
        'student_email',
        'answer',
        'file_paths',
        'answered_at',
        'activity_id',
        'hub_id',
        'user_id',
        'status',
        'reviewer_id',
        'reviewed_at',
        'reviewer_notes',
    ];

    protected $casts = [
        'file_paths' => 'array',
        'answered_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(DynamicQuestion::class);
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function hub(): BelongsTo
    {
        return $this->belongsTo(Hub::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'submitted');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeReviewed($query)
    {
        return $query->whereIn('status', ['approved', 'rejected']);
    }

    // Helper methods
    public function hasFiles(): bool
    {
        return !empty($this->file_paths) && is_array($this->file_paths);
    }

    public function getDisplayValueAttribute(): string
    {
        if ($this->question->type === 'file') {
            return $this->hasFiles() ? count($this->file_paths) . ' file(s) uploaded' : 'No files uploaded';
        }

        if (in_array($this->question->type, ['checkbox']) && is_array($this->answer)) {
            return implode(', ', $this->answer);
        }

        return $this->answer ?? '';
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'submitted' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            'reviewed' => 'blue',
            default => 'gray'
        };
    }

    public function getStatusDisplayAttribute(): string
    {
        return match($this->status) {
            'submitted' => 'Pending Review',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'reviewed' => 'Reviewed',
            default => ucfirst($this->status)
        };
    }


    
}



