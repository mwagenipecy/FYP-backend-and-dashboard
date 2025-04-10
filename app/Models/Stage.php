<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'description',
        'project_id',
        'phase_id',
        'order',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function phase()
    {
        return $this->belongsTo(ProjectPhase::class, 'phase_id');
    }

    public function submissions()
    {
        return $this->hasMany(StageSubmission::class);
    }

    public function latestSubmission()
    {
        return $this->hasOne(StageSubmission::class)->latest();
    }
}
