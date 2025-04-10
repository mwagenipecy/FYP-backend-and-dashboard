<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StageSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'stage_id',
        'user_id',
        'content',
        'status',
        'feedback',
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
