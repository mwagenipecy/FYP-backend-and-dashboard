<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectPhase extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'order',
        'project_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function stages()
    {
        return $this->hasMany(Stage::class, 'phase_id')->orderBy('order');
    }


}
