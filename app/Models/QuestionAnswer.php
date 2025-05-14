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
    ];

    protected $casts = [
        'file_paths' => 'array',
        'answered_at' => 'datetime',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(DynamicQuestion::class, 'question_id');
    }

    public function hasFiles(): bool
    {
        return !empty($this->file_paths);
    }

    public function getDisplayValueAttribute(): string
    {
        if ($this->hasFiles()) {
            return count($this->file_paths) . ' file(s) uploaded';
        }

        if ($this->question && in_array($this->question->type, ['radio', 'checkbox', 'select']) && $this->answer) {
            $answers = is_array($this->answer) ? $this->answer : json_decode($this->answer, true);
            return is_array($answers) ? implode(', ', $answers) : $this->answer;
        }

        return $this->answer ?? '';
    }
}