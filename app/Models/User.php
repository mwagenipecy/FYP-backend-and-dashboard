<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    public function supervisedHubs()
    {
        return $this->hasMany(Hub::class, 'supervisor_id');
    }

    /**
     * Get the hubs created by this user.
     */
    public function createdHubs()
    {
        return $this->hasMany(Hub::class, 'created_by');
    }

    /**
     * Get the hubs updated by this user.
     */
    public function updatedHubs()
    {
        return $this->hasMany(Hub::class, 'updated_by');
    }


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the level that owns the user.
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    
    /**
     * Check if the user has a specific role
     */
    public function hasRole($roleName)
    {
        return $this->role->name === $roleName;
    }
    
    /**
     * Check if the user is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
    
    /**
     * Check if the user is blocked
     */
    public function isBlocked()
    {
        return $this->status === 'blocked';
    }
    
    /**
     * Check if the user is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }
    
    /**
     * Check if the user is a pro user
     */
    public function isPro()
    {
        return $this->current_team_id !== null;
    }

    

    public function projectIdeas()
    {
        return $this->hasMany(ProjectIdea::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'user_has_projects')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function supervisingProjects()
    {
        return $this->belongsToMany(Project::class, 'user_has_projects')
            ->withPivot('role')
            ->wherePivot('role', 'supervisor')
            ->withTimestamps();
    }

    public function memberProjects()
    {
        return $this->belongsToMany(Project::class, 'user_has_projects')
            ->withPivot('role')
            ->wherePivot('role', 'member')
            ->withTimestamps();
    }

    public function stageSubmissions()
    {
        return $this->hasMany(StageSubmission::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }

 




}
