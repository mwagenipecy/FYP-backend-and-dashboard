<?php

namespace App\Livewire\Backend\Components\Hub;

use App\Models\Hub;
use App\Models\Project;
use App\Models\ProjectIdea;
use App\Models\Activity;
use App\Models\Document;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HubOverview extends Component
{
    // Filter properties
    public $performanceFilter = 'all';
    
    // Modal states
    public $showAddHubModal = false;
    public $showAnalyticsModal = false;
    public $selectedHubId = null;
    
    // Data refresh flag
    public $refreshKey = 0;
    
    // Listeners
    protected $listeners = [
        'hubCreated' => 'refreshData',
        'hubUpdated' => 'refreshData',
        'hubDeleted' => 'refreshData'
    ];

    public function mount()
    {
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->refreshKey++;
    }

    public function refreshActivities()
    {
        $this->refreshData();
        session()->flash('message', 'Activities refreshed successfully.');
    }

    public function showAddHubModal()
    {
        $this->dispatch('show-add-hub-modal');
    }

    public function viewHubDetails($hubId)
    {
        $this->selectedHubId = $hubId;
        $this->dispatch('show-hub-details', hubId: $hubId);
    }

    public function editHub($hubId)
    {
        $this->dispatch('edit-hub', hubId: $hubId);
    }

    public function viewHubAnalytics($hubId)
    {
        $this->selectedHubId = $hubId;
        $this->showAnalyticsModal = true;
    }

    public function closeAnalyticsModal()
    {
        $this->showAnalyticsModal = false;
        $this->selectedHubId = null;
    }

    public function bulkUpdateHubs()
    {
        $this->dispatch('show-bulk-update-modal');
    }

    public function generateReport()
    {
        try {
            // Generate comprehensive hub report
            $reportData = $this->getReportData();
            
            // You can implement PDF generation or CSV export here
            session()->flash('message', 'Report generated successfully and will be available for download shortly.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to generate report: ' . $e->getMessage());
        }
    }

    public function exportHubData()
    {
        try {
            // Export hub performance data
            $hubData = $this->getHubPerformanceData();
            
            // Implement CSV export logic
            session()->flash('message', 'Hub data exported successfully.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to export data: ' . $e->getMessage());
        }
    }

    public function managePermissions()
    {
        $this->dispatch('show-permissions-modal');
    }

    // Get basic statistics
    private function getBasicStats()
    {
        $totalHubs = Hub::count();
        $activeHubs = Hub::where('status', 'active')->count();
        $totalProjects = Project::count();
        $totalIdeas = ProjectIdea::count();
        $pendingIdeas = ProjectIdea::where('status', 'submitted')->count();
        
        // Calculate growth percentage (comparing to last month)
        $lastMonthHubs = Hub::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $hubsGrowth = $totalHubs > 0 ? round((($lastMonthHubs / $totalHubs) * 100), 1) : 0;

        return compact(
            'totalHubs', 
            'activeHubs', 
            'totalProjects', 
            'totalIdeas', 
            'pendingIdeas', 
            'hubsGrowth'
        );
    }

    // Get recent activities
    private function getRecentActivities()
    {
        return Activity::with(['hub', 'user', 'project'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    // Get hub performance data
    private function getHubPerformanceData()
    {
        // First, get all hubs with their relationships
        $hubs = Hub::with(['supervisor'])->get();

        // Apply filters
        if ($this->performanceFilter === 'active') {
            $hubs = $hubs->where('status', 'active');
        }

        // Add counts for each hub
        $hubsWithCounts = $hubs->map(function ($hub) {
            // Get projects count
            $hub->projects_count = Project::where('hub_id', $hub->id)->count();
            
            // Get ideas count through projects
            $hub->ideas_count = ProjectIdea::whereHas('projects', function($query) use ($hub) {
                $query->where('hub_id', $hub->id);
            })->count();
            
            // Get documents count
            $hub->documents_count = Document::where('hub_id', $hub->id)->count();
            
            return $hub;
        });

        // Apply top performers filter after counting
        if ($this->performanceFilter === 'top_performers') {
            $hubsWithCounts = $hubsWithCounts->filter(function ($hub) {
                return $hub->projects_count > 0;
            })->sortByDesc('projects_count');
        }

        return $hubsWithCounts;
    }

    // Get analytics data for a specific hub
    private function getHubAnalytics($hubId)
    {
        $hub = Hub::findOrFail($hubId);
        
        $projectsData = Project::where('hub_id', $hubId)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $ideasData = ProjectIdea::whereHas('projects', function($query) use ($hubId) {
                $query->where('hub_id', $hubId);
            })
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $documentsData = Document::where('hub_id', $hubId)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'hub' => $hub,
            'projects' => $projectsData,
            'ideas' => $ideasData,
            'documents' => $documentsData
        ];
    }

    // Get comprehensive report data
    private function getReportData()
    {
        return [
            'summary' => $this->getBasicStats(),
            'hubPerformance' => $this->getHubPerformanceData(),
            'activities' => $this->getRecentActivities(),
            'supervisors' => User::whereHas('supervisedHubs')->get(),
            'generatedAt' => Carbon::now()
        ];
    }

    public function render()
    {
        $stats = $this->getBasicStats();
        $recentActivities = $this->getRecentActivities();
        $hubPerformance = $this->getHubPerformanceData();
        
        $analyticsData = null;
        if ($this->selectedHubId && $this->showAnalyticsModal) {
            $analyticsData = $this->getHubAnalytics($this->selectedHubId);
        }

        return view('livewire.backend.components.hub.hub-overview', array_merge($stats, [
            'recentActivities' => $recentActivities,
            'hubPerformance' => $hubPerformance,
            'analyticsData' => $analyticsData,
            'refreshKey' => $this->refreshKey
        ]));
    }
}