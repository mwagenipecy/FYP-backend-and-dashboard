<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use App\Models\User;
use App\Models\Project;
use App\Models\Idea;
use App\Models\Activity;
use App\Models\StageSubmission;
use App\Models\Document;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberDashboard extends Component
{
    public $user;
    public $stats = [];
    public $recentActivities = [];
    public $myProjects = [];
    public $myIdeas = [];
    public $recentNotifications = [];
    public $monthlySubmissions = [];
    public $projectStatusChart = [];

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $userId = $this->user->id;

        // Load statistics
        $this->stats = [
            'total_projects' => $this->user->projects()->count(),
            'active_projects' => $this->user->projects()
                ->whereIn('status', ['in_progress', 'active'])
                ->count(),
            'completed_projects' => $this->user->projects()
                ->where('status', 'completed')
                ->count(),
            'submitted_ideas' => Idea::where('user_id', $userId)->count(),
            'approved_ideas' => Idea::where('user_id', $userId)
                ->where('status', 'approved')
                ->count(),
            'pending_submissions' => StageSubmission::where('user_id', $userId)
                ->where('status', 'submitted')
                ->count(),
            'uploaded_documents' => Document::where('uploaded_by', $userId)->count(),
            'unread_notifications' => Notification::where('user_id', $userId)
                ->whereNull('read_at')
                ->count(),
        ];

        // Load recent activities
        $this->recentActivities = Activity::where('user_id', $userId)
            ->with(['project', 'hub'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Load my projects
        $this->myProjects = $this->user->projects()
            ->with(['hub', 'phases'])
            ->orderBy('updated_at', 'desc')
            ->limit(6)
            ->get();

        // Load my ideas
        $this->myIdeas = Idea::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Load recent notifications
        $this->recentNotifications = Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Load monthly submissions data for chart
        $this->monthlySubmissions = StageSubmission::where('user_id', $userId)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Load project status chart data
        $this->projectStatusChart = $this->user->projects()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }

    public function markNotificationAsRead($notificationId)
    {
        Notification::where('id', $notificationId)
            ->where('user_id', $this->user->id)
            ->update(['read_at' => now()]);
        
        $this->loadDashboardData();
    }

    public function markAllNotificationsAsRead()
    {
        Notification::where('user_id', $this->user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        
        $this->loadDashboardData();
    }

    public function render()
    {
        return view('livewire.dashboards.member-dashboard');
    }
}