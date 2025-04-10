<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    ];

    protected $casts = [
        'issue_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    
}
