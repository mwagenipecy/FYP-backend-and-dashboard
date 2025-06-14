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
        'regno',
        'fieldType',
        'userType',

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

 


    public function userProjects(){


        return $this->belongsToMany(Project::class, 'user_has_projects', 'user_id', 'project_id');
    }





    
    const USER_TYPE_STUDENT = 'student';
    const USER_TYPE_STAFF = 'staff';

    /**
     * Field Types for Staff
     */
    const FIELD_TYPES = [
        'Technology' => 'Technology',
        'Education' => 'Education',
        'Health' => 'Health',
        'IoT' => 'Internet of Things (IoT)',
        'Engineering' => 'Engineering',
        'Business' => 'Business & Management',
        'Science' => 'Science & Research',
        'Arts' => 'Arts & Humanities',
        'Other' => 'Other'
    ];

    /**
     * Get the role that belongs to the user.
     */
  

    /**
     * Scope a query to only include students.
     */
    public function scopeStudents($query)
    {
        return $query->where('userType', self::USER_TYPE_STUDENT);
    }

    /**
     * Scope a query to only include staff.
     */
    public function scopeStaff($query)
    {
        return $query->where('userType', self::USER_TYPE_STAFF);
    }

    /**
     * Scope a query to filter by user type.
     */
    public function scopeByUserType($query, $userType)
    {
        return $query->where('userType', $userType);
    }

    /**
     * Scope a query to filter by role.
     */
    public function scopeByRole($query, $roleId)
    {
        return $query->where('role_id', $roleId);
    }

    /**
     * Scope a query to filter by level.
     */
    public function scopeByLevel($query, $levelId)
    {
        return $query->where('level_id', $levelId);
    }

    /**
     * Check if user is a student.
     */
    public function isStudent()
    {
        return $this->userType === self::USER_TYPE_STUDENT;
    }

    /**
     * Check if user is staff.
     */
    public function isStaff()
    {
        return $this->userType === self::USER_TYPE_STAFF;
    }

    /**
     * Get the display name for user type.
     */
    public function getUserTypeDisplayAttribute()
    {
        return ucfirst($this->userType);
    }

    /**
     * Get the appropriate identifier based on user type.
     * Returns registration number for students or field type for staff.
     */
    public function getIdentifierAttribute()
    {
        if ($this->isStudent()) {
            return $this->regno ?: 'N/A';
        } elseif ($this->isStaff()) {
            return $this->fieldType ?: 'N/A';
        }
        
        return $this->regno ?: $this->fieldType ?: 'N/A';
    }

    /**
     * Get user's initials for avatar.
     */
    public function getInitialsAttribute()
    {
        return strtoupper(substr($this->name, 0, 2));
    }

    /**
     * Mutator to ensure userType is lowercase.
     */
    public function setUserTypeAttribute($value)
    {
        $this->attributes['userType'] = strtolower($value);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Clear inappropriate fields based on user type when saving
        static::saving(function ($user) {
            if ($user->userType === self::USER_TYPE_STUDENT) {
                $user->fieldType = null;
            } elseif ($user->userType === self::USER_TYPE_STAFF) {
                $user->regno = null;
            }
        });
    }




    public function hubMemberships()
    {
        return $this->hasMany(HubMembership::class);
    }

    /**
     * Get the user's active hub memberships
     */
    public function activeHubMemberships()
    {
        return $this->hasMany(HubMembership::class)->where('status', 'active');
    }

    /**
     * Get hubs where user is a member
     */
    public function memberHubs()
    {
        return $this->belongsToMany(Hub::class, 'hub_memberships')
                    ->withPivot(['role', 'status', 'joined_at', 'approved_at'])
                    ->wherePivot('status', 'active');
    }

    /**
     * Get hubs where user can manage activities
     */
    public function managedHubs()
    {
        return $this->belongsToMany(Hub::class, 'hub_memberships')
                    ->withPivot(['role', 'status', 'joined_at', 'approved_at'])
                    ->wherePivot('status', 'active')
                    ->wherePivotIn('role', ['coordinator', 'supervisor', 'admin']);
    }

    /**
     * Get activities the user has participated in
     */
    public function activityParticipations()
    {
        return $this->hasMany(ActivityParticipant::class);
    }

    /**
     * Get activities the user has responded to
     */
    public function activityResponses()
    {
        return $this->hasMany(QuestionAnswer::class);
    }

    /**
     * Get activities created by the user
     */
    public function createdActivities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get responses reviewed by the user
     */
    public function reviewedResponses()
    {
        return $this->hasMany(QuestionAnswer::class, 'reviewer_id');
    }

    /**
     * Check if user is a member of a specific hub
     */
    public function isMemberOf(Hub $hub): bool
    {
        return $this->activeHubMemberships()
                    ->where('hub_id', $hub->id)
                    ->exists();
    }

    /**
     * Check if user can manage activities in a specific hub
     */
    public function canManageActivitiesIn(Hub $hub): bool
    {
        return $this->activeHubMemberships()
                    ->where('hub_id', $hub->id)
                    ->whereIn('role', ['coordinator', 'supervisor', 'admin'])
                    ->exists();
    }

    /**
     * Check if user can approve members in a specific hub
     */
    public function canApproveMembersIn(Hub $hub): bool
    {
        return $this->activeHubMemberships()
                    ->where('hub_id', $hub->id)
                    ->whereIn('role', ['supervisor', 'admin'])
                    ->exists();
    }

    /**
     * Get the user's current/primary hub
     */
    public function getCurrentHub(): ?Hub
    {
        return $this->activeHubMemberships()
                    ->with('hub')
                    ->first()?->hub;
    }

    /**
     * Get hub IDs that the user has access to
     */
    public function getAccessibleHubIds(): array
    {
        return $this->activeHubMemberships()
                    ->pluck('hub_id')
                    ->toArray();
    }

    /**
     * Get the user's role in a specific hub
     */
    public function getRoleInHub(Hub $hub): ?string
    {
        return $this->activeHubMemberships()
                    ->where('hub_id', $hub->id)
                    ->first()?->role;
    }

    /**
     * Check if user has participated in a specific activity
     */
    public function hasParticipatedIn(Activity $activity): bool
    {
        return $this->activityParticipations()
                    ->where('activity_id', $activity->id)
                    ->exists();
    }

    /**
     * Get user's participation status in an activity
     */
    public function getParticipationStatus(Activity $activity): ?string
    {
        return $this->activityParticipations()
                    ->where('activity_id', $activity->id)
                    ->first()?->status;
    }

    /**
     * Check if user can participate in an activity
     */
    public function canParticipateIn(Activity $activity): bool
    {
        // User must be a member of the activity's hub
        if (!$this->isMemberOf($activity->hub)) {
            return false;
        }

        // Activity must be open for registration
        if (!$activity->isRegistrationOpen()) {
            return false;
        }

        // Activity must have available slots
        if (!$activity->hasAvailableSlots()) {
            return false;
        }

        // User shouldn't already be participating
        if ($this->hasParticipatedIn($activity)) {
            return false;
        }

        return true;
    }

    /**
     * Join a hub (request membership)
     */
    public function requestHubMembership(Hub $hub, string $notes = null): HubMembership
    {
        return HubMembership::create([
            'hub_id' => $hub->id,
            'user_id' => $this->id,
            'role' => 'member',
            'status' => 'pending',
            'notes' => $notes,
        ]);
    }

    /**
     * Participate in an activity
     */
    public function participateIn(Activity $activity): ?ActivityParticipant
    {
        if (!$this->canParticipateIn($activity)) {
            return null;
        }

        return ActivityParticipant::create([
            'activity_id' => $activity->id,
            'user_id' => $this->id,
            'hub_id' => $activity->hub_id,
            'status' => $activity->auto_approve ? 'approved' : 'pending',
            'registration_date' => now(),
            'approved_at' => $activity->auto_approve ? now() : null,
            'approved_by' => $activity->auto_approve ? $activity->user_id : null,
        ]);
    }

    /**
     * Get user's dashboard statistics
     */
    public function getDashboardStats(): array
    {
        return [
            'total_hubs' => $this->activeHubMemberships()->count(),
            'total_activities' => $this->activityParticipations()->count(),
            'pending_activities' => $this->activityParticipations()->where('status', 'pending')->count(),
            'approved_activities' => $this->activityParticipations()->where('status', 'approved')->count(),
            'responses_given' => $this->activityResponses()->count(),
            'activities_managed' => $this->createdActivities()->count(),
        ];
    }





}
