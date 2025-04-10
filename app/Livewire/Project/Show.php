<?php

namespace App\Livewire\Project;

use App\Models\Project;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public Project $project;
    public $supervisorId;
    public $showSupervisorForm = false;
    public $showMembersForm = false;
    public $selectedMembers = [];
    public $availableUsers = [];

    protected $rules = [
        'supervisorId' => 'required|exists:users,id',
        'selectedMembers' => 'array',
        'selectedMembers.*' => 'exists:users,id',
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
        
        // Get supervisor if already assigned
        $supervisor = $project->supervisor()->first();
        if ($supervisor) {
            $this->supervisorId = $supervisor->id;
        }
        
        // Load available users for supervisor selection
        $this->loadAvailableUsers();
        
        // Get current members
        $members = $project->members()->get();
        foreach ($members as $member) {
            $this->selectedMembers[] = $member->id;
        }
    }

    public function loadAvailableUsers()
    {
        // Get users with proper roles who can be supervisors
        $this->availableUsers = User::whereHas('role', function ($query) {
            $query->where('name', 'Supervisor')->orWhere('name', 'Admin');
        })->get();
    }

    public function toggleSupervisorForm()
    {
        $this->showSupervisorForm = !$this->showSupervisorForm;
    }

    public function toggleMembersForm()
    {
        $this->showMembersForm = !$this->showMembersForm;
    }

    public function assignSupervisor()
    {
        $this->validate([
            'supervisorId' => 'required|exists:users,id',
        ]);
        
        // Remove any existing supervisors
        $this->project->users()->wherePivot('role', 'supervisor')->detach();
        
        // Assign new supervisor
        $this->project->users()->attach($this->supervisorId, ['role' => 'supervisor']);
        
        // Notify the assigned supervisor
        $supervisor = User::find($this->supervisorId);
        NotificationService::sendToUser(
            $supervisor,
            'Project Supervisor Assignment',
            'You have been assigned as a supervisor for the project "' . $this->project->title . '".',
            'View Project',
            route('projects.show', $this->project->id),
            'info'
        );
        
        // Record in activity log
        $supervisor->activities()->create([
            'name' => 'Supervisor Assigned',
            'description' => 'Assigned as supervisor to project: ' . $this->project->title,
            'type' => 'project',
            'project_id' => $this->project->id,
            'issue_date' => now(),
        ]);
        
        session()->flash('message', 'Supervisor assigned successfully.');
        $this->showSupervisorForm = false;
    }

    public function removeSupervisor()
    {
        // Remove supervisor
        $this->project->users()->wherePivot('role', 'supervisor')->detach();
        
        // Notify the removed supervisor
        $supervisor = User::find($this->supervisorId);
        NotificationService::sendToUser(
            $supervisor,
            'Project Supervisor Removal',
            'You have been removed from the project "' . $this->project->title . '".',
            'View Projects',
            route('projects.index'),
            'warning'
        );
        
        session()->flash('message', 'Supervisor removed successfully.');
        $this->showSupervisorForm = false;
    }
    public function updatedSelectedMembers($value)
    {
        // Validate selected members
        $this->validate([
            'selectedMembers' => 'array',
            'selectedMembers.*' => 'exists:users,id',
        ]);
    }
    public function updatedSupervisorId($value)
    {
        // Validate supervisor ID
        $this->validate([
            'supervisorId' => 'required|exists:users,id',
        ]);
    }
    public function updatedShowMembersForm($value)
    {
        // Validate show members form
        $this->validate([
            'showMembersForm' => 'boolean',
        ]);
    }
    public function updatedShowSupervisorForm($value)
    {
        // Validate show supervisor form
        $this->validate([
            'showSupervisorForm' => 'boolean',
        ]);
    }
    public function updatedAvailableUsers($value)
    {
        // Validate available users
        $this->validate([
            'availableUsers' => 'array',
            'availableUsers.*' => 'exists:users,id',
        ]);
    }
    public function updatedProject($value)
    {
        // Validate project
        $this->validate([
            'project' => 'required|exists:projects,id',
        ]);
    }
  

    public function assignMembers()
    {
        $this->validate([
            'selectedMembers' => 'array',
            'selectedMembers.*' => 'exists:users,id',
        ]);
        
        // Get current members
        $currentMembers = $this->project->members()->pluck('users.id')->toArray();
        
        // Find new members to add
        $newMembers = array_diff($this->selectedMembers, $currentMembers);
        
        // Find members to remove
        $removeMembers = array_diff($currentMembers, $this->selectedMembers);
        
        // Add new members
        foreach ($newMembers as $memberId) {
            $this->project->users()->attach($memberId, ['role' => 'member']);
            
            // Notify the assigned member
            $member = User::find($memberId);
            NotificationService::sendToUser(
                $member,
                'Project Member Assignment',
                'You have been assigned as a member for the project "' . $this->project->title . '".',
                'View Project',
                route('projects.show', $this->project->id),
                'info'
            );
            
            // Record in activity log
            $member->activities()->create([
                'name' => 'Member Assigned',
                'description' => 'Assigned as member to project: ' . $this->project->title,
                'type' => 'project',
                'project_id' => $this->project->id,
                'issue_date' => now(),
            ]);
        }
        
        // Remove members
        foreach ($removeMembers as $memberId) {
            $this->project->users()->wherePivot('role', 'member')->wherePivot('user_id', $memberId)->detach();
            
            // Notify the removed member
            $member = User::find($memberId);
            NotificationService::sendToUser(
                $member,
                'Project Member Removal',
                'You have been removed from the project "' . $this->project->title . '".',
                'View Projects',
                route('projects.index'),
                'warning'
            );
        }
        
        session()->flash('message', 'Project members updated successfully.');
        $this->showMembersForm = false;
    }

    public function render()
    {
        $supervisor = $this->project->supervisor()->first();
        $members = $this->project->members()->get();
        $phases = $this->project->phases()->with('stages')->orderBy('order')->get();
        
        $allUsers = User::whereHas('role', function ($query) {
            $query->where('name', '!=', 'Admin');
        })->get();
        
        return view('livewire.project.show', [
            'supervisor' => $supervisor,
            'members' => $members,
            'phases' => $phases,
            'allUsers' => $allUsers,
        ]);
    }
}












