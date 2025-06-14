<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HubMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'hub_id',
        'user_id',
        'role',
        'status',
        'joined_at',
        'approved_by',
        'approved_at',
        'notes',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function hub(): BelongsTo
    {
        return $this->belongsTo(Hub::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // Helper methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function canManageActivities(): bool
    {
        return $this->isActive() && in_array($this->role, ['coordinator', 'supervisor', 'admin']);
    }

    public function canApproveMembers(): bool
    {
        return $this->isActive() && in_array($this->role, ['supervisor', 'admin']);
    }
}