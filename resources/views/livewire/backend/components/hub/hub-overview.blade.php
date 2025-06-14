<div>
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg text-white p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">Hub Overview Dashboard</h1>
                <p class="text-blue-100">Comprehensive insights into your innovation hubs</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-blue-100">Last Updated</p>
                <p class="text-lg font-semibold">{{ now()->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Hubs -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Hubs</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalHubs }}</p>
                    <p class="text-sm text-gray-500 mt-1">
                        @if($hubsGrowth >= 0)
                            <span class="text-green-600">+{{ $hubsGrowth }}%</span> from last month
                        @else
                            <span class="text-red-600">{{ $hubsGrowth }}%</span> from last month
                        @endif
                    </p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-building text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Active Hubs -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Hubs</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $activeHubs }}</p>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ number_format(($activeHubs / $totalHubs) * 100, 1) }}% of total
                    </p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Projects -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Projects</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalProjects }}</p>
                    <p class="text-sm text-gray-500 mt-1">
                        Across all hubs
                    </p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-project-diagram text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Project Ideas -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Project Ideas</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalIdeas }}</p>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $pendingIdeas }} pending review
                    </p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-lightbulb text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Hub Status Distribution -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Hub Status Distribution</h3>
                <div class="flex space-x-2">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span>
                        Active ({{ $activeHubs }})
                    </span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-1"></span>
                        Inactive ({{ $totalHubs - $activeHubs }})
                    </span>
                </div>
            </div>
            <div class="relative">
                <canvas id="hubStatusChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Recent Activities</h3>
                <button wire:click="refreshActivities" class="text-blue-600 hover:text-blue-800 text-sm">
                    <i class="fas fa-refresh mr-1"></i> Refresh
                </button>
            </div>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                @forelse($recentActivities as $activity)
                <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="flex-shrink-0">
                        @if($activity->type === 'project_created')
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-plus text-blue-600 text-sm"></i>
                            </div>
                        @elseif($activity->type === 'idea_submitted')
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-lightbulb text-yellow-600 text-sm"></i>
                            </div>
                        @else
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-bell text-gray-600 text-sm"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">{{ $activity->name }}</p>
                        <p class="text-xs text-gray-500">{{ $activity->hub->name ?? 'System' }}</p>
                        <p class="text-xs text-gray-400">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="fas fa-inbox text-gray-300 text-2xl mb-2"></i>
                    <p class="text-gray-500 text-sm">No recent activities</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

  
    <!-- Loading Indicator -->
    <div wire:loading class="fixed inset-0 bg-black bg-opacity-25 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-4 flex items-center space-x-2">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
            <span class="text-gray-700">Loading...</span>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hub Status Chart
    const ctx = document.getElementById('hubStatusChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Inactive'],
            datasets: [{
                data: [{{ $activeHubs }}, {{ $totalHubs - $activeHubs }}],
                backgroundColor: ['#10B981', '#EF4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '70%'
        }
    });
});
</script>

</div>
