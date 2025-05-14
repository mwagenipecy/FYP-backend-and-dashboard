<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use App\Models\User;
use App\Models\Hub;
use App\Models\Project;
use App\Models\Document;
use App\Models\Activity;
use App\Models\Idea;
use App\Models\StageSubmission;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboard extends Component
{
    public $admin;
    public $systemStats = [];
    public $userStats = [];
    public $projectStats = [];
    public $hubStats = [];
    public $recentActivities = [];
    public $recentUsers = [];
    public $topHubs = [];
    public $topProjects = [];
    public $monthlyGrowth = [];
    public $statusDistribution = [];
    public $userGrowthChart = [];
    public $projectGrowthChart = [];
    public $hubPerformanceChart = [];

    public function mount()
    {
        $this->admin = Auth::user();
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        // System-wide statistics
        $this->systemStats = [
            'total_users' => User::count(),
            'total_hubs' => Hub::count(),
            'total_projects' => Project::count(),
            'total_ideas' => Idea::count(),
            'total_documents' => Document::count(),
            'total_activities' => Activity::count(),
            'pending_invitations' => Invitation::where('status', 'pending')->count(),
            'approved_documents' => Document::where('is_approved', true)->count(),
        ];

        // User statistics
        $this->userStats = [
            'active_users' => User::where('status', 'active')->count(),
            'new_users_this_month' => User::whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])->count(),
            'supervisors' => User::whereHas('role', function($q) {
                $q->where('name', 'supervisor');
            })->count(),
            'members' => User::whereHas('role', function($q) {
                $q->where('name', 'member');
            })->count(),
        ];

        // Project statistics
        $this->projectStats = [
            'active_projects' => Project::whereIn('status', ['in_progress', 'active'])->count(),
            'completed_projects' => Project::where('status', 'completed')->count(),
            'draft_projects' => Project::where('status', 'draft')->count(),
            'projects_this_month' => Project::whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])->count(),
        ];

        // Hub statistics
        $this->hubStats = [
            'active_hubs' => Hub::where('status', 'active')->count(),
            'hubs_with_projects' => Hub::whereHas('projects')->count(),
            'avg_projects_per_hub' => Hub::withCount('projects')->avg('id') ?? 0,
            'avg_members_per_hub' => $this->calculateAvgMembersPerHub(),
        ];

        // Recent activities (system-wide)
        $this->recentActivities = Activity::with(['user', 'hub', 'project'])
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();

        // Recent users
        $this->recentUsers = User::with(['role', 'level'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Top performing hubs
        $this->topHubs = Hub::withCount(['projects', 'activities'])
            ->orderByDesc('projects_count')
            ->limit(5)
            ->get();

        // Top projects by activity
        $this->topProjects = Project::withCount(['activities', 'stages'])
            ->orderByDesc('activities_count')
            ->limit(5)
            ->get();

        // Monthly growth data
        $this->monthlyGrowth = [
            'users' => $this->getMonthlyGrowth(User::class),
            'projects' => $this->getMonthlyGrowth(Project::class),
            'hubs' => $this->getMonthlyGrowth(Hub::class),
            'ideas' => $this->getMonthlyGrowth(Idea::class),
        ];

        // Status distribution for projects
        $this->statusDistribution = Project::groupBy('status')
            ->selectRaw('status, count(*) as count')
            ->pluck('count', 'status')
            ->toArray();

        // User growth chart data (last 12 months)
        $this->userGrowthChart = $this->getUserGrowthData();

        // Project growth chart data (last 12 months)
        $this->projectGrowthChart = $this->getProjectGrowthData();

        // Hub performance chart data
        $this->hubPerformanceChart = $this->getHubPerformanceData();
    }

    private function calculateAvgMembersPerHub()
    {
        $hubMembers = Hub::select('hubs.id')
            ->leftJoin('projects', 'hubs.id', '=', 'projects.hub_id')
            ->leftJoin('user_has_projects', 'projects.id', '=', 'user_has_projects.project_id')
            ->groupBy('hubs.id')
            ->selectRaw('COUNT(DISTINCT user_has_projects.user_id) as member_count')
            ->get();

        return $hubMembers->avg('member_count') ?? 0;
    }

    private function getMonthlyGrowth($model)
    {
        $currentMonth = $model::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])->count();

        $lastMonth = $model::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count();

        $growthRate = $lastMonth > 0 ? (($currentMonth - $lastMonth) / $lastMonth) * 100 : 0;

        return [
            'current' => $currentMonth,
            'last' => $lastMonth,
            'growth_rate' => round($growthRate, 1)
        ];
    }

    private function getUserGrowthData()
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $data[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }
        return $data;
    }

    private function getProjectGrowthData()
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Project::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $data[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }
        return $data;
    }

    private function getHubPerformanceData()
    {
        return Hub::select('hubs.name', 'hubs.id')
            ->withCount('projects')
            ->withCount('activities')
            ->orderByDesc('projects_count')
            ->limit(8)
            ->get()
            ->map(function($hub) {
                return [
                    'name' => $hub->name,
                    'projects' => $hub->projects_count,
                    'activities' => $hub->activities_count
                ];
            });
    }

    public function render()
    {
        return view('livewire.dashboards.admin-dashboard');
    }
}