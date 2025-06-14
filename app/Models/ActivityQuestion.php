<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'question_id',
        'display_order',
        'is_required',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(DynamicQuestion::class);
    }

    // Scopes
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }
}