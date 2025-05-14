<div>
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Supervisor Dashboard</h1>
            <div class="flex items-center mt-2">
                <p class="text-gray-600">Managing: </p>
                @if($hub)
                    <span class="ml-2 px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                        {{ $hub->name }}
                    </span>
                @else
                    <span class="ml-2 text-red-600">No hub assigned</span>
                @endif
            </div>
        </div>

        @if($hub)
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Hub Members</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $stats['total_hub_members'] }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.196-2.121M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.196-2.121M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-sm text-green-600">{{ $hubStats['member_engagement'] }}% engagement rate</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Active Projects</p>
                            <p class="text-3xl font-bold text-green-600">{{ $stats['active_projects'] }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-sm text-gray-600">{{ $stats['completed_projects'] }} completed</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Pending Approvals</p>
                            <p class="text-3xl font-bold text-orange-600">{{ $stats['pending_document_approvals'] }}</p>
                        </div>
                        <div class="p-3 bg-orange-100 rounded-full">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
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
                            <p class="text-sm text-gray-600">Avg. Completion</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $hubStats['avg_project_completion'] }}%</p>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-full">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-sm text-green-600">{{ $hubStats['this_month_projects'] }} this month</span>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Monthly Projects Chart -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Monthly Project Creation</h3>
                    <div class="h-64" wire:ignore>
                        <canvas id="monthlyProjectsChart"></canvas>
                    </div>
                </div>

                <!-- Hub Performance Chart -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Project Status Distribution</h3>
                    <div class="h-64" wire:ignore>
                        <canvas id="hubPerformanceChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Pending Approvals -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Document Approvals</h3>
                    </div>
                    <div class="p-6">
                        @if($pendingApprovals->count() > 0)
                            <div class="space-y-4">
                                @foreach($pendingApprovals as $document)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900">{{ $document->title }}</h4>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    By: {{ optional($document->uploadedBy)->name }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    Project: {{ $document->stage->project->title ?? 'N/A' }}
                                                </p>
                                                <p class="text-xs text-gray-400 mt-1">
                                                    {{ $document->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button wire:click="approveDocument({{ $document->id }})"
                                                    class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full hover:bg-green-200 transition-colors">
                                                Approve
                                            </button>
                                            <button wire:click="rejectDocument({{ $document->id }})"
                                                    class="px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full hover:bg-red-200 transition-colors">
                                                Reject
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No pending approvals</h3>
                                <p class="mt-1 text-sm text-gray-500">All documents have been reviewed.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Hub Projects -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Hub Projects</h3>
                    </div>
                    <div class="p-6">
                        @if($hubProjects->count() > 0)
                            <div class="space-y-4">
                                @foreach($hubProjects->take(6) as $project)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900">{{ $project->title }}</h4>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    {{ Str::limit($project->description, 80) }}
                                                </p>
                                                <div class="flex items-center mt-2 space-x-4">
                                                    <span class="text-xs text-gray-500">
                                                        {{ $project->userProjects->count() }} members
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
                                <p class="mt-1 text-sm text-gray-500">Projects will appear here when created.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Hub Activities</h3>
                    </div>
                    <div class="p-6">
                        @if($recentActivities->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentActivities->take(6) as $activity)
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                @if($activity->type === 'approval')
                                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @elseif($activity->type === 'rejection')
                                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-900">{{ $activity->name }}</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $activity->description }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $activity->user->name ?? 'System' }} • {{ $activity->created_at->diffForHumans() }}
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

            <!-- Hub Members Section -->
            <div class="mt-8">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Hub Members</h3>
                    </div>
                    <div class="p-6">
                        @if($hubMembers->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($hubMembers as $member)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                @if($member->profile_photo_path)
                                                    <img class="w-10 h-10 rounded-full" src="{{ $member->profile_photo_path }}" alt="{{ $member->name }}">
                                                @else
                                                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                                        <span class="text-sm font-medium text-gray-700 uppercase">
                                                            {{ substr($member->name, 0, 2) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $member->name }}</h4>
                                                <p class="text-xs text-gray-500">{{ $member->email }}</p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    {{ $member->projects_count }} projects
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-sm text-gray-500">No members found in this hub</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        @else
            <!-- No Hub Assigned -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No Hub Assigned</h3>
                <p class="mt-1 text-sm text-gray-500">
                    You need to be assigned to a hub to access the supervisor dashboard.
                </p>
                <p class="mt-1 text-sm text-gray-500">
                    Please contact an administrator for assistance.
                </p>
            </div>
        @endif

        <!-- Flash Messages -->
        @if(session()->has('message'))
            <div class="fixed top-4 right-4 z-50 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Monthly Projects Chart
            const monthlyData = @json($monthlyProjectStats);
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
                               'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            
            const monthlyLabels = [];
            const monthlyValues = [];
            
            for (let i = 1; i <= 12; i++) {
                monthlyLabels.push(monthNames[i-1]);
                monthlyValues.push(monthlyData[i] || 0);
            }

            const monthlyProjectsCtx = document.getElementById('monthlyProjectsChart');
            if (monthlyProjectsCtx) {
                new Chart(monthlyProjectsCtx, {
                    type: 'bar',
                    data: {
                        labels: monthlyLabels,
                        datasets: [{
                            label: 'Projects Created',
                            data: monthlyValues,
                            backgroundColor: 'rgba(59, 130, 246, 0.8)',
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 1
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
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y + ' project' + (context.parsed.y !== 1 ? 's' : '');
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Hub Performance Chart
            const performanceData = @json($hubPerformanceChart);
            const statusLabels = Object.keys(performanceData);
            const statusValues = Object.values(performanceData);
            
            const statusColors = {
                'draft': '#6B7280',
                'in_progress': '#3B82F6',
                'completed': '#10B981',
                'on_hold': '#F59E0B',
                'cancelled': '#EF4444'
            };

            const hubPerformanceCtx = document.getElementById('hubPerformanceChart');
            if (hubPerformanceCtx && statusLabels.length > 0) {
                new Chart(hubPerformanceCtx, {
                    type: 'doughnut',
                    data: {
                        labels: statusLabels.map(label => 
                            label.charAt(0).toUpperCase() + label.slice(1).replace('_', ' ')
                        ),
                        datasets: [{
                            data: statusValues,
                            backgroundColor: statusLabels.map(status => statusColors[status] || '#6B7280'),
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
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                                        return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });

        // Auto-hide flash messages
        setTimeout(function() {
            const flashMessage = document.querySelector('[role="alert"]');
            if (flashMessage) {
                flashMessage.style.opacity = '0';
                setTimeout(() => flashMessage.remove(), 300);
            }
        }, 5000);
    </script>
</div>

</div>
