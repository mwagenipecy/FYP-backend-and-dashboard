<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'email',
        'token',
        'role',
        'message',
        'status',
        'invited_by',
        'expires_at',
        'accepted_at',
        'declined_at',
        'cancelled_at',
        'cancelled_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
        'declined_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Get the project that this invitation is for.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who is being invited (if they already exist).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who sent the invitation.
     */
    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    /**
     * Get the user who cancelled the invitation.
     */
    public function canceller()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    /**
     * Check if the invitation is expired.
     */
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if the invitation is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending' && !$this->isExpired();
    }

    /**
     * Check if the invitation can be accepted.
     */
    public function canBeAccepted()
    {
        return $this->isPending();
    }

    /**
     * Accept the invitation.
     */
    public function accept()
    {
        if (!$this->canBeAccepted()) {
            return false;
        }

        $this->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        return true;
    }

    /**
     * Decline the invitation.
     */
    public function decline()
    {
        if (!$this->isPending()) {
            return false;
        }

        $this->update([
            'status' => 'declined',
            'declined_at' => now(),
        ]);

        return true;
    }
}