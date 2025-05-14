<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use App\Models\Hub;
use App\Models\User;
use App\Models\Project;
use App\Models\Document;
use App\Models\Activity;
use App\Models\Idea;
use App\Models\StageSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupervisorDashboard extends Component
{
    public $supervisor;
    public $hub;
    public $stats = [];
    public $hubStats = [];
    public $recentActivities = [];
    public $pendingApprovals = [];
    public $hubProjects = [];
    public $hubMembers = [];
    public $monthlyProjectStats = [];
    public $hubPerformanceChart = [];
    public $pendingDocuments = [];

    public function mount()
    {
        $this->supervisor = Auth::user();
        $this->hub = Hub::where('supervisor_id', $this->supervisor->id)->first();
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        if (!$this->hub) {
            return;
        }

        $hubId = $this->hub->id;

        // Load general statistics
        $this->stats = [
            'total_hubs_supervised' => Hub::where('supervisor_id', $this->supervisor->id)->count(),
            'total_hub_members' => User::whereHas('userProjects', function($q) use ($hubId) {
                $q->whereHas('project', function($query) use ($hubId) {
                    $query->where('hub_id', $hubId);
                });
            })->distinct()->count(),
            'active_projects' => Project::where('hub_id', $hubId)
                ->whereIn('status', ['in_progress', 'active'])
                ->count(),
            'completed_projects' => Project::where('hub_id', $hubId)
                ->where('status', 'completed')
                ->count(),
            'pending_document_approvals' => Document::where('hub_id', $hubId)
                ->where('is_approved', false)
                ->count(),
            'total_activities' => Activity::where('hub_id', $hubId)->count(),
            'recent_submissions' => StageSubmission::whereHas('stage.project', function($q) use ($hubId) {
                $q->where('hub_id', $hubId);
            })->where('status', 'submitted')->count(),
            'hub_ideas' => Project::where('hub_id', $hubId)
                ->whereNotNull('idea_id')
                ->count(),
        ];

        // Load hub-specific statistics
        $this->hubStats = [
            'total_projects' => Project::where('hub_id', $hubId)->count(),
            'this_month_projects' => Project::where('hub_id', $hubId)
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->count(),
            'avg_project_completion' => $this->calculateAvgProjectCompletion($hubId),
            'member_engagement' => $this->calculateMemberEngagement($hubId),
        ];

        // Load recent activities
        $this->recentActivities = Activity::where('hub_id', $hubId)
            ->with(['user', 'project'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Load pending document approvals
        $this->pendingApprovals = Document::where('hub_id', $hubId)
            ->where('is_approved', false)
            ->with(['uploadedBy', 'stage.project'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Load hub projects with their teams
        $this->hubProjects = Project::where('hub_id', $hubId)
            ->with(['userProjects.user', 'stages'])
            ->orderBy('updated_at', 'desc')
            ->limit(8)
            ->get();

        // Load hub members with their project count
        $this->hubMembers = User::whereHas('userProjects', function($q) use ($hubId) {
            $q->whereHas('project', function($query) use ($hubId) {
                $query->where('hub_id', $hubId);
            });
        })->withCount(['userProjects as projects_count' => function($q) use ($hubId) {
            $q->whereHas('project', function($query) use ($hubId) {
                $query->where('hub_id', $hubId);
            });
        }])->distinct()->limit(10)->get();

        // Load monthly project statistics for chart
        $this->monthlyProjectStats = Project::where('hub_id', $hubId)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Load hub performance chart data
        $this->hubPerformanceChart = [
            'completed' => Project::where('hub_id', $hubId)->where('status', 'completed')->count(),
            'in_progress' => Project::where('hub_id', $hubId)->whereIn('status', ['in_progress', 'active'])->count(),
            'draft' => Project::where('hub_id', $hubId)->where('status', 'draft')->count(),
            'on_hold' => Project::where('hub_id', $hubId)->where('status', 'on_hold')->count(),
        ];

        // Load all pending documents for approval
        $this->pendingDocuments = Document::where('hub_id', $hubId)
            ->where('is_approved', false)
            ->with(['uploadedBy', 'stage.project'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    private function calculateAvgProjectCompletion($hubId)
    {
        $projects = Project::where('hub_id', $hubId)->get();
        if ($projects->isEmpty()) return 0;

        $totalCompletion = 0;
        foreach ($projects as $project) {
            $totalStages = $project->stages()->count();
            $completedStages = $project->stages()->where('status', 'completed')->count();
            $completion = $totalStages > 0 ? ($completedStages / $totalStages) * 100 : 0;
            $totalCompletion += $completion;
        }

        return round($totalCompletion / $projects->count(), 1);
    }

    private function calculateMemberEngagement($hubId)
    {
        $totalMembers = User::whereHas('userProjects', function($q) use ($hubId) {
            $q->whereHas('project', function($query) use ($hubId) {
                $query->where('hub_id', $hubId);
            });
        })->distinct()->count();

        $activeMembers = User::whereHas('userProjects', function($q) use ($hubId) {
            $q->whereHas('project', function($query) use ($hubId) {
                $query->where('hub_id', $hubId);
            });
        })->whereHas('activities', function($q) {
            $q->where('created_at', '>=', now()->subWeek());
        })->distinct()->count();

        return $totalMembers > 0 ? round(($activeMembers / $totalMembers) * 100, 1) : 0;
    }

    public function approveDocument($documentId)
    {
        $document = Document::where('id', $documentId)
            ->where('hub_id', $this->hub->id)
            ->first();

        if ($document) {
            $document->update([
                'is_approved' => true,
                'approved_by' => $this->supervisor->id,
                'approved_at' => now()
            ]);

            // Create activity log
            Activity::create([
                'hub_id' => $this->hub->id,
                'user_id' => $this->supervisor->id,
                'name' => 'Document Approved',
                'description' => "Approved document: {$document->title}",
                'type' => 'approval',
                'created_at' => now()
            ]);

            $this->loadDashboardData();
            session()->flash('message', 'Document approved successfully!');
        }
    }

    public function rejectDocument($documentId, $reason = null)
    {
        $document = Document::where('id', $documentId)
            ->where('hub_id', $this->hub->id)
            ->first();

        if ($document) {
            // Create activity log for rejection
            Activity::create([
                'hub_id' => $this->hub->id,
                'user_id' => $this->supervisor->id,
                'name' => 'Document Rejected',
                'description' => "Rejected document: {$document->title}" . ($reason ? " - Reason: {$reason}" : ""),
                'type' => 'rejection',
                'created_at' => now()
            ]);

            // For this example, we'll delete the document
            // In a real application, you might want to mark it as rejected instead
            $document->delete();

            $this->loadDashboardData();
            session()->flash('message', 'Document rejected successfully!');
        }
    }

    public function render()
    {
        return view('livewire.dashboards.supervisor-dashboard');
    }
}