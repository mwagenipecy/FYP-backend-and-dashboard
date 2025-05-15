<?php

namespace App\Livewire\IndividualProject;

use Livewire\Component;
use App\Models\Project;
use App\Models\Stage;
use App\Models\ProjectPhase;
use App\Models\Activity;
use App\Models\Document;
use App\Models\User;
use App\Models\StageSubmission;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $project;
    public $projectStats;
    public $phases;
    public $recentActivities;
    public $upcomingDeadlines;
    public $teamMembers;
    public $documents;

    public function mount()
    {
        $this->project = Project::find(session('project')->id);
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        // Calculate project statistics
        $this->calculateProjectStats();
        
        // Load project phases with stages
        $this->loadProjectPhases();
        
        // Load recent activities
        $this->loadRecentActivities();
        
        // Load upcoming deadlines
        $this->loadUpcomingDeadlines();
        
        // Load team members
        $this->loadTeamMembers();
        
        // Load recent documents
        $this->loadRecentDocuments();
    }

    private function calculateProjectStats()
    {
        $totalStages = Stage::where('project_id', $this->project->id)->count();
        $completedStages = Stage::where('project_id', $this->project->id)
            ->where('status', 'completed')
            ->count();
        
        $totalTasks = Activity::where('project_id', $this->project->id)->count();
        $completedTasks = Activity::where('project_id', $this->project->id)
           // ->where('status', 'completed')
            ->count();
        
        $totalDocuments = Document::whereHas('stage', function ($query) {
            $query->where('project_id', $this->project->id);
        })->count();
        
        $approvedDocuments = Document::whereHas('stage', function ($query) {
            $query->where('project_id', $this->project->id);
        })->where('is_approved', 1)->count();
        
        $this->projectStats = [
            'progress_percentage' => $totalStages > 0 ? round(($completedStages / $totalStages) * 100) : 0,
            'tasks_completed' => $completedTasks,
            'tasks_total' => $totalTasks,
            'documents_approved' => $approvedDocuments,
            'documents_total' => $totalDocuments,
            'current_phase' => $this->getCurrentPhase(),
        ];
    }

    private function getCurrentPhase()
    {
        $currentPhase = ProjectPhase::where('project_id', $this->project->id)
            ->whereHas('stages', function ($query) {
                $query->where('status', 'in_progress');
            })
            ->first();
        
        return $currentPhase ? $currentPhase->name : 'Planning';
    }

    private function loadProjectPhases()
    {
        $this->phases = ProjectPhase::where('project_id', $this->project->id)
            ->with(['stages' => function ($query) {
                $query->orderBy('order');
            }])
            ->orderBy('order')
            ->get()
            ->map(function ($phase) {
                $totalStages = $phase->stages->count();
                $completedStages = $phase->stages->where('status', 'completed')->count();
                $inProgressStages = $phase->stages->where('status', 'in_progress')->count();
                
                $phase->completion_percentage = $totalStages > 0 ? 
                    round(($completedStages / $totalStages) * 100) : 0;
                
                if ($completedStages === $totalStages && $totalStages > 0) {
                    $phase->status = 'completed';
                } elseif ($inProgressStages > 0 || $completedStages > 0) {
                    $phase->status = 'in_progress';
                } else {
                    $phase->status = 'not_started';
                }
                
                return $phase;
            });
    }

    private function loadRecentActivities()
    {
        $this->recentActivities = Activity::where('project_id', $this->project->id)
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();
    }

    private function loadUpcomingDeadlines()
    {
        $this->upcomingDeadlines = Stage::where('project_id', $this->project->id)
            ->whereNotNull('end_date')
            ->where('end_date', '>', now())
           // ->where('status', '!=', 'completed')
           // ->orderBy('end_date')
            ->limit(5)
            ->get()
            ->map(function ($stage) {
                $endDate = $stage->end_date ?? '2025-08-22';
                $stage->days_left = now()->diffInDays(Carbon\Carbon::parse($endDate), false);
                return $stage;
            });
            
    }

    private function loadTeamMembers()
    {
        $this->teamMembers = User::whereHas('projects', function ($query) {
            $query->where('project_id', $this->project->id);
        })
        ->with(['projects' => function ($query) {
            $query->where('project_id', $this->project->id);
        }])
        ->get();
    }

    private function loadRecentDocuments()
    {
        $this->documents = Document::whereHas('stage', function ($query) {
            $query->where('project_id', $this->project->id);
        })
        ->with(['stage', 'uploadedBy'])
        ->latest()
        ->limit(5)
        ->get();
    }

    public function render()
    {
        return view('livewire.individual-project.dashboard', [
            'project' => $this->project,
            'projectStats' => $this->projectStats,
            'phases' => $this->phases,
            'recentActivities' => $this->recentActivities,
            'upcomingDeadlines' => $this->upcomingDeadlines,
            'teamMembers' => $this->teamMembers,
            'documents' => $this->documents,
        ]);
    }
}