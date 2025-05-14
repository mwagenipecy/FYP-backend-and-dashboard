<?php
// app/Models/DynamicQuestion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'options' => 'array',
        'required' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($question) {
            if (!$question->order) {
                $question->order = static::max('order') + 1;
            }
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}