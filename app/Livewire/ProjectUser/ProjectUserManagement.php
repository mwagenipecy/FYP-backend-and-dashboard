<?php

namespace App\Livewire\ProjectUser;


use App\Mail\ProjectInvitationMail;
use App\Models\Project;
use App\Models\User;
use App\Models\Invitation;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectUserManagement extends Component
{
    use WithPagination;
    
    public Project $project;
    public $supervisor;
    public $members = [];
    public $availableUsers = [];
    public $supervisorId;
    public $selectedMembers = [];
    public $selectedUsersToInvite = [];
    public $invitationEmail;
    public $invitationRole = 'member';
    public $invitationMessage;
    public $activeTab = 'members';
    public $showSupervisorForm = false;
    public $showMembersForm = false;
    public $showInvitationForm = false;
    public $searchQuery = '';
    public $pendingInvitations = [];
    
    protected $rules = [
        'supervisorId' => 'nullable|exists:users,id',
        'selectedMembers' => 'array',
        'selectedMembers.*' => 'exists:users,id',
        'selectedUsersToInvite' => 'array',
        'selectedUsersToInvite.*' => 'exists:users,id',
        'invitationEmail' => 'nullable|email',
        'invitationRole' => 'required|in:member,supervisor',
        'invitationMessage' => 'nullable|string|max:500',
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->loadProjectUsers();
        $this->loadAvailableUsers();
        $this->loadPendingInvitations();
    }
    
    public function loadProjectUsers()
    {
        // Get supervisor if already assigned
        $this->supervisor = $this->project->supervisor()->first();
        if ($this->supervisor) {
            $this->supervisorId = $this->supervisor->id;
        }
        
        // Get current members
        $members = $this->project->members()->get();
        $this->members = $members;
        $this->selectedMembers = $members->pluck('id')->toArray();
    }
    
    public function loadAvailableUsers()
    {
        // Get all users except the current user and those already in the project
        $projectUserIds = $this->project->users()->pluck('users.id')->toArray();
        
        $query = User::whereNotIn('id', $projectUserIds);
        
        // Filter by search query if provided
        if (!empty($this->searchQuery)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchQuery . '%')
                  ->orWhere('email', 'like', '%' . $this->searchQuery . '%');
            });
        }
        
        $this->availableUsers = $query->get();
    }
    
    public function loadPendingInvitations()
    {
        $this->pendingInvitations = Invitation::where('project_id', $this->project->id)
            ->where('status', 'pending')
            ->get();
    }
    
    public function updatedSearchQuery()
    {
        $this->loadAvailableUsers();
    }
    
    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }
    
    public function toggleSupervisorForm()
    {
        if (!$this->canManageProject()) {
            session()->flash('error', 'You do not have permission to manage project supervisors.');
            return;
        }
        
        $this->showSupervisorForm = !$this->showSupervisorForm;
        
        if ($this->showSupervisorForm) {
            // Load users who can be supervisors (those with Supervisor or Admin roles)
            $this->availableUsers = User::whereHas('role', function ($query) {
                $query->where('name', 'Supervisor')->orWhere('name', 'Admin');
            })->get();
        }
    }
    
    public function toggleMembersForm()
    {
        if (!$this->canManageProject()) {
            session()->flash('error', 'You do not have permission to manage project members.');
            return;
        }
        
        $this->showMembersForm = !$this->showMembersForm;
        $this->loadAvailableUsers();
    }
    
    public function toggleInvitationForm()
    {
        if (!$this->canManageProject()) {
            session()->flash('error', 'You do not have permission to send invitations.');
            return;
        }
        
        $this->showInvitationForm = !$this->showInvitationForm;
        $this->reset(['invitationEmail', 'invitationRole', 'invitationMessage', 'selectedUsersToInvite']);
    }
    
    public function assignSupervisor()
    {
        if (!$this->canManageProject()) {
            session()->flash('error', 'You do not have permission to assign supervisors.');
            return;
        }
        
        $this->validate([
            'supervisorId' => 'required|exists:users,id',
        ]);
        
        // Check if the selected supervisor is already a member
        $isMember = $this->project->members()->where('users.id', $this->supervisorId)->exists();
        if ($isMember) {
            // Remove from members first
            $this->project->users()->wherePivot('role', 'member')->wherePivot('user_id', $this->supervisorId)->detach();
        }
        
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
        $this->loadProjectUsers();
    }
    
    public function removeSupervisor()
    {
        if (!$this->canManageProject()) {
            session()->flash('error', 'You do not have permission to remove supervisors.');
            return;
        }
        
        if (!$this->supervisor) {
            session()->flash('error', 'No supervisor is currently assigned.');
            return;
        }
        
        // Remove supervisor
        $this->project->users()->wherePivot('role', 'supervisor')->detach();
        
        // Notify the removed supervisor
        NotificationService::sendToUser(
            $this->supervisor,
            'Project Supervisor Removal',
            'You have been removed from the project "' . $this->project->title . '".',
            'View Projects',
            route('projects.index'),
            'warning'
        );
        
        session()->flash('message', 'Supervisor removed successfully.');
        $this->showSupervisorForm = false;
        $this->reset(['supervisorId', 'supervisor']);
        $this->loadProjectUsers();
    }
    
    public function assignMembers()
    {
        if (!$this->canManageProject()) {
            session()->flash('error', 'You do not have permission to manage project members.');
            return;
        }
        
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
        
        // Prevent removing the current user if they are a member
        if (in_array(Auth::id(), $removeMembers)) {
            session()->flash('error', 'You cannot remove yourself from the project.');
            return;
        }
        
        // Make sure the supervisor is not being added as a member
        if ($this->supervisor && in_array($this->supervisor->id, $this->selectedMembers)) {
            session()->flash('error', 'The supervisor cannot also be added as a member.');
            return;
        }
        
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
        $this->loadProjectUsers();
    }
    
    public function sendInvitationToExisting()
    {
        if (!$this->canManageProject()) {
            session()->flash('error', 'You do not have permission to send invitations.');
            return;
        }
        
        $this->validate([
            'selectedUsersToInvite' => 'required|array|min:1',
            'selectedUsersToInvite.*' => 'exists:users,id',
            'invitationRole' => 'required|in:member,supervisor',
            'invitationMessage' => 'nullable|string|max:500',
        ]);

        
        foreach ($this->selectedUsersToInvite as $userId) {
            $user = User::find($userId);


            
            // Create invitation record
            $invitation = Invitation::create([
                'project_id' => $this->project->id,
                'user_id' => $userId,
                'email' => $user->email,
                'token' => Str::random(64),
                'role' => $this->invitationRole,
                'message' => $this->invitationMessage,
                'status' => 'pending',
                'invited_by' => Auth::id(),
                'expires_at' => now()->addDays(7),
            ]);


           
            
            // Send notification to the user
            NotificationService::sendToUser(
                $user,
                'Project Invitation',
                'You have been invited to join the project "' . $this->project->title . '" as a ' . $this->invitationRole . '.',
                'View Invitation',
                route('invitations.show', $invitation->token),
                'info'
            );
        }
        
        session()->flash('message', 'Invitations sent successfully.');
        $this->showInvitationForm = false;
        $this->reset(['selectedUsersToInvite', 'invitationRole', 'invitationMessage']);
        $this->loadPendingInvitations();
    }
    
    public function sendInvitationToNew()
    {
        if (!$this->canManageProject()) {
            session()->flash('error', 'You do not have permission to send invitations.');
            return;
        }
        
        $this->validate([
            'invitationEmail' => 'required|email',
            'invitationRole' => 'required|in:member,supervisor',
            'invitationMessage' => 'nullable|string|max:500',
        ]);
        
        // Check if user already exists with this email
        $existingUser = User::where('email', $this->invitationEmail)->first();
        
        if ($existingUser) {

            dd('existing');
            // If user exists, add to selectedUsersToInvite and use the other method
            $this->selectedUsersToInvite = [$existingUser->id];
            $this->sendInvitationToExisting();
            return;
        }
        
        // Create invitation for non-existing user
        $invitation = Invitation::create([
            'project_id' => $this->project->id,
            'user_id' => null,
            'email' => $this->invitationEmail,
            'token' => Str::random(64),
            'role' => $this->invitationRole,
            'message' => $this->invitationMessage,
            'status' => 'pending',
            'invited_by' => Auth::id(),
            'expires_at' => now()->addDays(7),
        ]);
        
        // Send email to the user with registration link
        // TODO: Implement sending emails to non-existing users
        // This would typically use Laravel's Mail facade

        Mail::to($this->invitationEmail)->send(new ProjectInvitationMail($invitation));

        
        session()->flash('message', 'Invitation sent to ' . $this->invitationEmail . ' successfully.');
        $this->showInvitationForm = false;


        $this->reset(['invitationEmail', 'invitationRole', 'invitationMessage']);
        $this->loadPendingInvitations();
    }
    
    public function cancelInvitation($invitationId)
    {
        if (!$this->canManageProject()) {
            session()->flash('error', 'You do not have permission to cancel invitations.');
            return;
        }
        
        $invitation = Invitation::findOrFail($invitationId);
        
        if ($invitation->project_id != $this->project->id) {
            session()->flash('error', 'This invitation does not belong to this project.');
            return;
        }
        
        $invitation->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancelled_by' => Auth::id(),
        ]);
        
        // Notify the user if they exist
        if ($invitation->user_id) {
            $user = User::find($invitation->user_id);
            NotificationService::sendToUser(
                $user,
                'Project Invitation Cancelled',
                'Your invitation to join the project "' . $this->project->title . '" has been cancelled.',
                'View Projects',
                route('project.users',session('project')->id),
                'warning'
            );
        }
        
        session()->flash('message', 'Invitation cancelled successfully.');
        $this->loadPendingInvitations();
    }

    
    
    public function resendInvitation($invitationId)
    {
        if (!$this->canManageProject()) {
            session()->flash('error', 'You do not have permission to resend invitations.');
            return;
        }
        
        $invitation = Invitation::findOrFail($invitationId);
        
        if ($invitation->project_id != $this->project->id) {
            session()->flash('error', 'This invitation does not belong to this project.');
            return;
        }
        
        // Update expiration date
        $invitation->update([
            'expires_at' => now()->addDays(7),
        ]);
        
        // Notify the user if they exist
        if ($invitation->user_id) {
            $user = User::find($invitation->user_id);
            NotificationService::sendToUser(
                $user,
                'Project Invitation Reminder',
                'This is a reminder that you have been invited to join the project "' . $this->project->title . '" as a ' . $invitation->role . '.',
                'View Invitation',
                route('invitations.show', $invitation->token),
                'info'
            );
        } else {

            // If user doesn't exist, resend email
            Mail::to($invitation->email)->send(new ProjectInvitationMail($invitation));
        }
        
        session()->flash('message', 'Invitation resent successfully.');
        $this->loadPendingInvitations();
    }
    
    private function canManageProject()
    {
        $user = Auth::user();
        
        // Check if user is the project supervisor
        if ($this->supervisor && $this->supervisor->id == $user->id) {
            return true;
        }
        
        // Check if user has Admin role
        return $user->role && $user->role->name === 'Admin';
    }

    public function render()
    {
        return view('livewire.project-user.project-user-management', [
            'project' => $this->project,
            'canManageProject' => $this->canManageProject(),
        ]);
    }
}