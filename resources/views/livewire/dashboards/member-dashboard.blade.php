<div>
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ $user->name }}!</h1>
            <p class="text-gray-600 mt-2">Here's what's happening with your projects and activities</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Projects</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['total_projects'] }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2h10a2 2 0 012 2v2M7 7V4a2 2 0 012-2h6a2 2 0 012 2v3"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-green-600">{{ $stats['active_projects'] }} active</span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Submitted Ideas</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $stats['submitted_ideas'] }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-green-600">{{ $stats['approved_ideas'] }} approved</span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Pending Submissions</p>
                        <p class="text-3xl font-bold text-orange-600">{{ $stats['pending_submissions'] }}</p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-full">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-500">Awaiting review</span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Notifications</p>
                        <p class="text-3xl font-bold text-red-600">{{ $stats['unread_notifications'] }}</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-full">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <button wire:click="markAllNotificationsAsRead" class="text-sm text-blue-600 hover:text-blue-800">
                        Mark all as read
                    </button>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Monthly Submissions Chart -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Monthly Submissions</h3>
                <div class="h-64" wire:ignore>
                    <canvas id="monthlySubmissionsChart"></canvas>
                </div>
            </div>

            <!-- Project Status Chart -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Project Status Distribution</h3>
                <div class="h-64" wire:ignore>
                    <canvas id="projectStatusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- My Projects -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">My Projects</h3>
                    </div>
                    <div class="p-6">
                        @if($myProjects->count() > 0)
                            <div class="space-y-4">
                                @foreach($myProjects as $project)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900">{{ $project->title }}</h4>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    {{ Str::limit($project->description, 100) }}
                                                </p>
                                                <div class="flex items-center mt-2 space-x-4">
                                                    <span class="text-xs text-gray-500">
                                                        Hub: {{ $project->hub->name ?? 'N/A' }}
                                                    </span>
                                                    <span class="text-xs text-gray-500">
                                                        Updated {{ $project->updated_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                @php
                                                    $statusColors = [
                                                        'draft' => 'bg-gray-100 text-gray-800',
                                                        'in_progress' => 'bg-blue-100 text-blue-800',
                                                        'completed' => 'bg-green-100 text-green-800',
                                                        'on_hold' => 'bg-yellow-100 text-yellow-800',
                                                        'cancelled' => 'bg-red-100 text-red-800'
                                                    ];
                                                @endphp
                                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$project->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2h10a2 2 0 012 2v2M7 7V4a2 2 0 012-2h6a2 2 0 012 2v3"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No projects yet</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating your first project.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- My Ideas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">My Ideas</h3>
                    </div>
                    <div class="p-6">
                        @if($myIdeas->count() > 0)
                            <div class="space-y-4">
                                @foreach($myIdeas as $idea)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900">{{ $idea->title }}</h4>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    {{ Str::limit($idea->description, 100) }}
                                                </p>
                                                <span class="text-xs text-gray-500">
                                                    Submitted {{ $idea->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'approved' => 'bg-green-100 text-green-800',
                                                        'rejected' => 'bg-red-100 text-red-800'
                                                    ];
                                                @endphp
                                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$idea->status] }}">
                                                    {{ ucfirst($idea->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No ideas submitted</h3>
                                <p class="mt-1 text-sm text-gray-500">Share your innovative ideas with the community.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Notifications & Activities -->
            <div class="space-y-6">
                <!-- Recent Notifications -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Notifications</h3>
                    </div>
                    <div class="p-6">
                        @if($recentNotifications->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentNotifications->take(5) as $notification)
                                    <div class="flex items-start space-x-3 {{ $notification->read_at ? 'opacity-60' : '' }}">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-900">
                                                @php
                                                    $data = json_decode($notification->data, true);
                                                @endphp
                                                {{ $data['message'] ?? $notification->type }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        @if(!$notification->read_at)
                                            <button wire:click="markNotificationAsRead({{ $notification->id }})" 
                                                    class="text-xs text-blue-600 hover:text-blue-800">
                                                Mark as read
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-sm text-gray-500">No notifications yet</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Activities</h3>
                    </div>
                    <div class="p-6">
                        @if($recentActivities->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentActivities->take(5) as $activity)
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-900">{{ $activity->name }}</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $activity->description }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $activity->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-sm text-gray-500">No recent activities</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Monthly Submissions Chart
            const monthlyData = @json($monthlySubmissions);
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
                               'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            
            const monthlyLabels = [];
            const monthlyValues = [];
            
            for (let i = 1; i <= 12; i++) {
                monthlyLabels.push(monthNames[i-1]);
                monthlyValues.push(monthlyData[i] || 0);
            }

            new Chart(document.getElementById('monthlySubmissionsChart'), {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Submissions',
                        data: monthlyValues,
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Project Status Chart
            const statusData = @json($projectStatusChart);
            const statusLabels = Object.keys(statusData);
            const statusValues = Object.values(statusData);
            const statusColors = [
                '#EF4444', // red
                '#F59E0B', // amber
                '#10B981', // emerald
                '#3B82F6', // blue
                '#8B5CF6', // violet
                '#6B7280'  // gray
            ];

            if (statusLabels.length > 0) {
                new Chart(document.getElementById('projectStatusChart'), {
                    type: 'doughnut',
                    data: {
                        labels: statusLabels.map(label => label.charAt(0).toUpperCase() + label.slice(1).replace('_', ' ')),
                        datasets: [{
                            data: statusValues,
                            backgroundColor: statusColors.slice(0, statusLabels.length),
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</div>

</div>
