<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectIdea extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
        'idea_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
