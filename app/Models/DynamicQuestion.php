<?php
// app/Models/DynamicQuestion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DynamicQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'description',
        'type',
        'options',
        'required',
        'order',
        'activity_id',
        'hub_id',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'options' => 'array',
        'required' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function hub(): BelongsTo
    {
        return $this->belongsTo(Hub::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(QuestionAnswer::class, 'question_id');
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'activity_questions')
                    ->withPivot('display_order', 'is_required');
    }

    // Scopes
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRequired($query)
    {
        return $query->where('required', true);
    }

    // Helper methods
    public function getFormattedOptionsAttribute(): array
    {
        if (!$this->options || !in_array($this->type, ['radio', 'checkbox', 'select'])) {
            return [];
        }

        return array_map(function($option, $index) {
            return [
                'value' => $option,
                'label' => $option,
                'id' => $index,
            ];
        }, $this->options, array_keys($this->options));
    }

    public function getTypeDisplayAttribute(): string
    {
        $types = [
            'text' => 'Text Input',
            'textarea' => 'Long Text',
            'email' => 'Email Address',
            'date' => 'Date',
            'file' => 'File Upload',
            'radio' => 'Single Choice',
            'checkbox' => 'Multiple Choice',
            'select' => 'Dropdown',
            'number' => 'Number',
            'url' => 'Website URL',
        ];

        return $types[$this->type] ?? ucfirst($this->type);
    }
}