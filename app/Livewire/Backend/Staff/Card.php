<?php

namespace App\Livewire\Backend\Staff;

use App\Models\User;
use App\Models\Role;
use App\Models\Level;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Card extends Component
{
    // Chart type selector
    public $chartType = 'bar'; // 'line', 'bar', 'doughnut'
    
    // Time period selector
    public $timePeriod = 'last_12_months'; // 'last_7_days', 'last_30_days', 'last_6_months', 'last_12_months'
    
    // User type filter for charts
    public $userTypeFilter = 'all'; // 'all', 'student', 'staff'

    public function mount()
    {
        // Initialize with default values
    }

    /**
     * Get total user counts by type
     */
    public function getTotalUsers()
    {
        return [
            'total' => User::count(),
            'students' => User::where('userType', 'student')->count(),
            'staff' => User::where('userType', 'staff')->count(),
            'active' => User::where('status', 'active')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
        ];
    }

    /**
     * Get user registration data for charts based on time period
     */
    public function getRegistrationData()
    {
        $query = User::query();
        
        // Filter by user type if specified
        if ($this->userTypeFilter !== 'all') {
            $query->where('userType', $this->userTypeFilter);
        }

        switch ($this->timePeriod) {
            case 'last_7_days':
                return $this->getDataForDays($query, 7);
            case 'last_30_days':
                return $this->getDataForDays($query, 30);
            case 'last_6_months':
                return $this->getDataForMonths($query, 6);
            case 'last_12_months':
            default:
                return $this->getDataForMonths($query, 12);
        }
    }

    /**
     * Get daily registration data
     */
    private function getDataForDays($query, $days)
    {
        $startDate = Carbon::now()->subDays($days - 1)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $data = $query->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Fill missing dates with zero
        $result = [];
        for ($i = 0; $i < $days; $i++) {
            $date = Carbon::now()->subDays($days - 1 - $i)->format('Y-m-d');
            $label = Carbon::now()->subDays($days - 1 - $i)->format('M j');
            $result[] = [
                'label' => $label,
                'value' => $data->get($date)->count ?? 0
            ];
        }

        return $result;
    }

    /**
     * Get monthly registration data
     */
    private function getDataForMonths($query, $months)
    {
        $startDate = Carbon::now()->subMonths($months - 1)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $data = $query->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        // Fill missing months with zero
        $result = [];
        for ($i = 0; $i < $months; $i++) {
            $date = Carbon::now()->subMonths($months - 1 - $i);
            $monthKey = $date->format('Y-m');
            $label = $date->format('M Y');
            $result[] = [
                'label' => $label,
                'value' => $data->get($monthKey)->count ?? 0
            ];
        }

        return $result;
    }

    /**
     * Get user distribution by roles
     */
    // public function getRoleDistribution()
    // {
    //     return User::join('roles', 'users.role_id', '=', 'roles.id')
    //         ->select('roles.name as role_name', DB::raw('COUNT(*) as count'))
    //         ->groupBy('roles.id', 'roles.name')
    //         ->orderBy('count', 'desc')
    //         ->get()
    //         ->toArray();
    // }

    /**
     * Get user distribution by levels
     */
    public function getLevelDistribution()
    {
        return User::join('levels', 'users.level_id', '=', 'levels.id')
            ->select('levels.name as level_name', DB::raw('COUNT(*) as count'))
            ->groupBy('levels.id', 'levels.name')
            ->orderBy('count', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Get field type distribution for staff
     */
    public function getFieldTypeDistribution()
    {
        $data = User::where('userType', 'staff')
            ->whereNotNull('fieldType')
            ->select('fieldType', DB::raw('COUNT(*) as count'))
            ->groupBy('fieldType')
            ->orderBy('count', 'desc')
            ->get();

        // Add colors to each field type
        $colors = ['#3B82F6', '#8B5CF6', '#EF4444', '#10B981', '#F59E0B', '#EC4899', '#6B7280', '#84CC16'];
        
        return $data->map(function ($item, $index) use ($colors) {
            return [
                'fieldType' => $item->fieldType,
                'count' => $item->count,
                'color' => $colors[$index % count($colors)]
            ];
        })->toArray();
    }

    /**
     * Get recent registrations
     */
    public function getRecentRegistrations()
    {
        return User::with(['role', 'level'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Calculate growth percentage
     */
    public function getGrowthPercentage()
    {
        $currentMonth = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $lastMonth = User::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        if ($lastMonth == 0) {
            return $currentMonth > 0 ? 100 : 0;
        }

        return round((($currentMonth - $lastMonth) / $lastMonth) * 100, 1);
    }

    /**
     * Update chart type
     */
    public function updateChartType($type)
    {
        $this->chartType = $type;
    }

    /**
     * Update time period
     */
    public function updateTimePeriod($period)
    {
        $this->timePeriod = $period;
    }

    /**
     * Update user type filter
     */
    public function updateUserTypeFilter($filter)
    {
        $this->userTypeFilter = $filter;
    }

    /**
     * Get color for field type charts
     */
    public function getFieldColor($index)
    {
        $colors = ['#3B82F6', '#8B5CF6', '#EF4444', '#10B981', '#F59E0B', '#EC4899', '#6B7280', '#84CC16'];
        return $colors[$index % count($colors)];
    }

    /**
     * Get role distribution with colors
     */
    public function getRoleDistribution()
    {
        $data = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->select('roles.name as role_name', DB::raw('COUNT(*) as count'))
            ->groupBy('roles.id', 'roles.name')
            ->orderBy('count', 'desc')
            ->get();

        $colors = ['#3B82F6', '#8B5CF6', '#EF4444', '#10B981', '#F59E0B', '#EC4899', '#6B7280', '#84CC16'];
        
        return $data->map(function ($item, $index) use ($colors) {
            return [
                'role_name' => $item->role_name,
                'count' => $item->count,
                'color' => $colors[$index % count($colors)]
            ];
        })->toArray();
    }

    /**
     * Get status summary
     */
    public function getStatusSummary()
    {
        return [
            'active' => User::where('status', 'active')->count(),
            'inactive' => User::where('status', 'inactive')->orWhereNull('status')->count(),
            'pending' => User::where('status', 'pending')->count(),
            'suspended' => User::where('status', 'suspended')->count(),
        ];
    }

    /**
     * Get user type comparison data
     */
    public function getUserTypeComparison()
    {
        $students = User::where('userType', 'student');
        $staff = User::where('userType', 'staff');

        return [
            'students' => [
                'total' => $students->count(),
                'active' => $students->where('status', 'active')->count(),
                'this_month' => $students->whereMonth('created_at', Carbon::now()->month)->count(),
            ],
            'staff' => [
                'total' => $staff->count(),
                'active' => $staff->where('status', 'active')->count(),
                'this_month' => $staff->whereMonth('created_at', Carbon::now()->month)->count(),
            ]
        ];
    }

    public function render()
    {
        $data = [
            'totalUsers' => $this->getTotalUsers(),
            'registrationData' => $this->getRegistrationData(),
            'roleDistribution' => $this->getRoleDistribution(),
            'levelDistribution' => $this->getLevelDistribution(),
            'fieldTypeDistribution' => $this->getFieldTypeDistribution(),
            'recentRegistrations' => $this->getRecentRegistrations(),
            'growthPercentage' => $this->getGrowthPercentage(),
            'statusSummary' => $this->getStatusSummary(),
            'userTypeComparison' => $this->getUserTypeComparison(),
        ];

        return view('livewire.backend.staff.card', $data);
    }
}