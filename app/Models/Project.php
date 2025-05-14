<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'status',
        'stage',
        'hub_id',
        'idea_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_projects')
            ->withPivot('role')
            ->withTimestamps();
    }


    public function Idea(){

        return $this->belongsTo(ProjectIdea::class,'idea_id');
    }



    public function supervisor()
    {
        return $this->belongsToMany(User::class, 'user_has_projects')
            ->withPivot('role')
            ->wherePivot('role', 'supervisor')
            ->withTimestamps();
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'user_has_projects')
            ->withPivot('role')
            ->wherePivot('role', 'member')
            ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsToMany(User::class, 'user_has_projects')
            ->withPivot('role')
            ->wherePivot('role', 'creator')
            ->withTimestamps();
    }

    public function phases()
    {
        return $this->hasMany(ProjectPhase::class)->orderBy('order');
    }

    public function stages()
    {
        return $this->hasMany(Stage::class)->orderBy('order');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }


    public function userProjects(){

        return $this->belongsToMany(Project::class, 'user_has_projects', 'user_id', 'project_id');

    }



    public function project(){

        return $this->belongsToMany(Project::class, 'user_has_projects', 'user_id', 'project_id');

    }


    public function user(){

        return $this->belongsToMany(Project::class, 'user_has_projects', 'user_id', 'project_id');

    }

}
