<?php

namespace App\Livewire\Backend\Components\Hub;

use App\Models\Hub;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectIdea;
use App\Models\UserHasProject;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HubSummary extends Component
{
    use WithPagination;
    
    // Hub properties
    public $hubId;
    public $selectedHub;
    
    // Statistics
    public $totalMembers = 0;
    public $activeProjects = 0;
    public $completedProjects = 0;
    public $pendingIdeas = 0;
    
    // Filters and search
    public $memberSearch = '';
    public $projectStatusFilter = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    
    // Modal states
    public $showMemberModal = false;
    public $showAddMemberModal = false;
    public $selectedMember = null;
    public $showMemberActions = [];
    
    // Listeners
    protected $listeners = [
        'hubSelected' => 'loadHub',
        'refreshHubData' => 'loadHubData'
    ];

    public function mount($hubId = null)
    {
        if ($hubId) {
            $this->hubId = $hubId;
            $this->loadHub($hubId);
        }
    }

    public function loadHub($hubId)
    {
        $this->hubId = $hubId;
        $this->selectedHub = Hub::with('supervisor')->findOrFail($hubId);
        $this->loadHubData();
    }

    private function loadHubData()
    {
        if (!$this->selectedHub) return;

        // Get members (users who have projects in this hub) using the pivot table
        $this->totalMembers = User::whereExists(function($query) {
            $query->select(DB::raw(1))
                ->from('user_has_projects')
                ->join('projects', 'user_has_projects.project_id', '=', 'projects.id')
                ->whereColumn('user_has_projects.user_id', 'users.id')
                ->where('projects.hub_id', $this->hubId);
        })->distinct()->count();

        // Get project statistics
        $this->activeProjects = Project::where('hub_id', $this->hubId)
            ->where('status', 'active')
            ->count();

        $this->completedProjects = Project::where('hub_id', $this->hubId)
            ->whereIn('status', ['completed', 'finished'])
            ->count();

        // Get pending ideas that could become projects in this hub
        $this->pendingIdeas = ProjectIdea::where('status', 'submitted')
            ->whereDoesntHave('projects', function($query) {
                $query->where('hub_id', $this->hubId);
            })
            ->count();
    }

    // Search and filter updates
    public function updatedMemberSearch()
    {
        $this->resetPage();
    }

    public function updatedProjectStatusFilter()
    {
        $this->resetPage();
    }

    // Sorting
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Member actions
    public function toggleMemberActions($memberId)
    {
        if (isset($this->showMemberActions[$memberId])) {
            unset($this->showMemberActions[$memberId]);
        } else {
            $this->showMemberActions = [];
            $this->showMemberActions[$memberId] = true;
        }
    }

    public function viewMemberDetails($memberId)
    {
        $member = User::findOrFail($memberId);
        
        // Get member's projects in this hub using the pivot table
        $hubProjects = Project::where('hub_id', $this->hubId)
            ->whereHas('users', function($query) use ($memberId) {
                $query->where('users.id', $memberId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $member->hub_projects = $hubProjects;
        $member->projects_count = $hubProjects->count();

        $this->selectedMember = $member;
        $this->showMemberModal = true;
        $this->showMemberActions = [];
    }

    public function closeMemberModal()
    {
        $this->showMemberModal = false;
        $this->selectedMember = null;
    }

    public function viewMemberProjects($memberId)
    {
        // Redirect to projects page filtered by member and hub
        session()->flash('message', 'Redirecting to member projects...');
        // You can implement redirect logic here
        $this->showMemberActions = [];
    }

    public function sendMessage($memberId)
    {
        // Open messaging interface
        session()->flash('message', 'Opening message composer...');
        // You can implement messaging logic here
        $this->showMemberActions = [];
    }

    public function assignToProject($memberId)
    {
        // Show project assignment modal
        session()->flash('message', 'Opening project assignment...');
        // You can implement project assignment logic here
        $this->showMemberActions = [];
    }

    public function changeRole($memberId)
    {
        // Show role change modal
        session()->flash('message', 'Opening role management...');
        // You can implement role change logic here
        $this->showMemberActions = [];
    }

    public function removeMember($memberId)
    {
        try {
            // Remove user from all projects in this hub
            $projects = Project::where('hub_id', $this->hubId)->pluck('id');
            UserHasProject::whereIn('project_id', $projects)
                ->where('user_id', $memberId)
                ->delete();

            session()->flash('message', 'Member removed from hub successfully.');
            $this->loadHubData();
            $this->showMemberActions = [];
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to remove member: ' . $e->getMessage());
        }
    }

    public function showAddMemberModal()
    {
        $this->showAddMemberModal = true;
    }

    public function closeAddMemberModal()
    {
        $this->showAddMemberModal = false;
    }

    public function exportMembers()
    {
        try {
            // Implement CSV export of members
            session()->flash('message', 'Member export initiated. Download will start shortly.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to export members: ' . $e->getMessage());
        }
    }

    public function editHub()
    {
        // Dispatch event to parent component to edit hub
        $this->dispatch('edit-hub', hubId: $this->hubId);
    }

    public function viewProject($projectId)
    {
        // Redirect to project details
        session()->flash('message', 'Redirecting to project details...');
        // You can implement redirect logic here
    }

    // Get hub members with their project information
    private function getHubMembers()
    {
        $query = User::select('users.*')
            ->join('user_has_projects', 'users.id', '=', 'user_has_projects.user_id')
            ->join('projects', 'user_has_projects.project_id', '=', 'projects.id')
            ->where('projects.hub_id', $this->hubId)
            ->distinct();

        // Apply search filter
        if ($this->memberSearch) {
            $query->where(function($q) {
                $q->where('users.name', 'like', '%' . $this->memberSearch . '%')
                  ->orWhere('users.email', 'like', '%' . $this->memberSearch . '%')
                  ->orWhere('users.regno', 'like', '%' . $this->memberSearch . '%');
            });
        }

        // Apply project status filter
        if ($this->projectStatusFilter) {
            $query->where('projects.status', $this->projectStatusFilter);
        }

        // Apply sorting
        $query->orderBy('users.' . $this->sortField, $this->sortDirection);

        $members = $query->paginate(10);

        // Add additional data for each member
        $members->getCollection()->transform(function ($member) {
            // Get latest project in this hub
            $latestProject = Project::where('hub_id', $this->hubId)
                ->whereExists(function($query) use ($member) {
                    $query->select(DB::raw(1))
                        ->from('user_has_projects')
                        ->whereColumn('user_has_projects.project_id', 'projects.id')
                        ->where('user_has_projects.user_id', $member->id);
                })
                ->orderBy('created_at', 'desc')
                ->first();

            $member->latest_project = $latestProject;

            // Get project counts for this hub using subqueries
            $projectIds = DB::table('user_has_projects')
                ->join('projects', 'user_has_projects.project_id', '=', 'projects.id')
                ->where('projects.hub_id', $this->hubId)
                ->where('user_has_projects.user_id', $member->id)
                ->pluck('projects.id');

            $member->projects_count = $projectIds->count();
            $member->active_projects_count = Project::whereIn('id', $projectIds)->where('status', 'active')->count();
            $member->completed_projects_count = Project::whereIn('id', $projectIds)->whereIn('status', ['completed', 'finished'])->count();

            // Get first project date in this hub
            $firstProject = Project::where('hub_id', $this->hubId)
                ->whereExists(function($query) use ($member) {
                    $query->select(DB::raw(1))
                        ->from('user_has_projects')
                        ->whereColumn('user_has_projects.project_id', 'projects.id')
                        ->where('user_has_projects.user_id', $member->id);
                })
                ->orderBy('created_at', 'asc')
                ->first();

            $member->first_project_date = $firstProject ? $firstProject->created_at : null;

            // Get user role from latest project
            $userRole = DB::table('user_has_projects')
                ->join('projects', 'user_has_projects.project_id', '=', 'projects.id')
                ->where('projects.hub_id', $this->hubId)
                ->where('user_has_projects.user_id', $member->id)
                ->orderBy('user_has_projects.created_at', 'desc')
                ->first();

            $member->user_role = $userRole ? ucfirst($userRole->role) : 'Member';

            return $member;
        });

        return $members;
    }

    public function render()
    {
        $hubMembers = collect();
        
        if ($this->selectedHub) {
            $hubMembers = $this->getHubMembers();
        }

        return view('livewire.backend.components.hub.hub-summary', [
            'hubMembers' => $hubMembers,
            'selectedHub' => $this->selectedHub,
            'totalMembers' => $this->totalMembers,
            'activeProjects' => $this->activeProjects,
            'completedProjects' => $this->completedProjects,
            'pendingIdeas' => $this->pendingIdeas
        ]);
    }
}