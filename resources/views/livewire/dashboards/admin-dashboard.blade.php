<div>


<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="text-gray-600 mt-2">System-wide overview and management</p>
        </div>

        <!-- Main System Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Users</p>
                        <p class="text-3xl font-bold text-blue-600">{{ number_format($systemStats['total_users']) }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center">
                        @if($monthlyGrowth['users']['growth_rate'] > 0)
                            <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span class="text-sm text-green-600">+{{ $monthlyGrowth['users']['growth_rate'] }}% this month</span>
                        @elseif($monthlyGrowth['users']['growth_rate'] < 0)
                            <svg class="w-4 h-4 text-red-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                            </svg>
                            <span class="text-sm text-red-600">{{ $monthlyGrowth['users']['growth_rate'] }}% this month</span>
                        @else
                            <span class="text-sm text-gray-600">{{ $monthlyGrowth['users']['current'] }} new this month</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Hubs</p>
                        <p class="text-3xl font-bold text-green-600">{{ number_format($systemStats['total_hubs']) }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-600">{{ $hubStats['active_hubs'] }} active</span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Projects</p>
                        <p class="text-3xl font-bold text-purple-600">{{ number_format($systemStats['total_projects']) }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2h10a2 2 0 012 2v2M7 7V4a2 2 0 012-2h6a2 2 0 012 2v3"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-green-600">{{ $projectStats['active_projects'] }} active</span>
                        <span class="text-sm text-gray-600">{{ $projectStats['completed_projects'] }} completed</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Ideas</p>
                        <p class="text-3xl font-bold text-orange-600">{{ number_format($systemStats['total_ideas']) }}</p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-full">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center">
                        @if($monthlyGrowth['ideas']['growth_rate'] > 0)
                            <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span class="text-sm text-green-600">+{{ $monthlyGrowth['ideas']['growth_rate'] }}% this month</span>
                        @elseif($monthlyGrowth['ideas']['growth_rate'] < 0)
                            <svg class="w-4 h-4 text-red-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                            </svg>
                            <span class="text-sm text-red-600">{{ $monthlyGrowth['ideas']['growth_rate'] }}% this month</span>
                        @else
                            <span class="text-sm text-gray-600">{{ $monthlyGrowth['ideas']['current'] }} new this month</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($systemStats['total_documents']) }}</p>
                    <p class="text-sm text-gray-600">Documents</p>
                    <p class="text-xs text-green-600 mt-1">{{ $systemStats['approved_documents'] }} approved</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($systemStats['total_activities']) }}</p>
                    <p class="text-sm text-gray-600">Activities</p>
                    <p class="text-xs text-gray-500 mt-1">System-wide</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ round($hubStats['avg_projects_per_hub'], 1) }}</p>
                    <p class="text-sm text-gray-600">Avg Projects/Hub</p>
                    <p class="text-xs text-gray-500 mt-1">Performance metric</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                <div class="text-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $systemStats['pending_invitations'] }}</p>
                    <p class="text-sm text-gray-600">Pending Invitations</p>
                    <p class="text-xs text-orange-600 mt-1">Needs attention</p>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- User Growth Chart -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">User Growth Trend (Last 12 Months)</h3>
                <div class="h-64" wire:ignore>
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>

            <!-- Project Status Distribution -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Project Status Distribution</h3>
                <div class="h-64" wire:ignore>
                    <canvas id="projectStatusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Hub Performance Chart -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Hub Performance Overview</h3>
            <div class="h-80" wire:ignore>
                <canvas id="hubPerformanceChart"></canvas>
            </div>
        </div>

        <!-- Content Tables Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Top Performing Hubs -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Top Performing Hubs</h3>
                </div>
                <div class="p-6">
                    @if($topHubs->count() > 0)
                        <div class="space-y-4">
                            @foreach($topHubs as $index => $hub)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-blue-100 text-blue-800 rounded-full flex items-center justify-center text-sm font-semibold">
                                                {{ $index + 1 }}
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900">{{ $hub->name }}</h4>
                                            <p class="text-sm text-gray-600">
                                                {{ $hub->projects_count }} projects • {{ $hub->activities_count }} activities
                                            </p>
                                            @if($hub->phone_number)
                                                <p class="text-xs text-gray-500">{{ $hub->phone_number }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                            Active
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hub data available</h3>
                            <p class="mt-1 text-sm text-gray-500">Hubs will appear here when created.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Recent System Activities</h3>
                </div>
                <div class="p-6">
                    @if($recentActivities->count() > 0)
                        <div class="space-y-4 max-h-96 overflow-y-auto">
                            @foreach($recentActivities->take(8) as $activity)
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            @if($activity->type === 'approval')
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @elseif($activity->type === 'creation')
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
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
                                        <div class="flex items-center mt-1 space-x-2">
                                            <p class="text-xs text-gray-500">
                                                {{ $activity->user->name ?? 'System' }}
                                            </p>
                                            @if($activity->hub)
                                                <span class="text-xs text-gray-400">•</span>
                                                <p class="text-xs text-gray-500">
                                                    {{ $activity->hub->name }}
                                                </p>
                                            @endif
                                            <span class="text-xs text-gray-400">•</span>
                                            <p class="text-xs text-gray-500">
                                                {{ $activity->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No recent activities</h3>
                            <p class="mt-1 text-sm text-gray-500">System activities will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Bottom Row: Recent Users and Statistics -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Recent Users -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Users</h3>
                </div>
                <div class="p-6">
                    @if($recentUsers->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentUsers->take(6) as $user)
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        @if($user->profile_photo_path)
                                            <img class="w-10 h-10 rounded-full object-cover" src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}">
                                        @else
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-medium text-white uppercase">
                                                    {{ substr($user->name, 0, 2) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $user->name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                        <div class="flex items-center mt-1 space-x-2">
                                            @if($user->role)
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                                    {{ ucfirst($user->role->name) }}
                                                </span>
                                            @endif
                                            @if($user->regno)
                                                <span class="text-xs text-gray-500">{{ $user->regno }}</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Joined {{ $user->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No recent users</h3>
                            <p class="mt-1 text-sm text-gray-500">New users will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- User Statistics Breakdown -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">User Statistics</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Active Users</h4>
                                <p class="text-xs text-gray-600">Currently active in the system</p>
                            </div>
                            <span class="text-2xl font-bold text-blue-600">{{ number_format($userStats['active_users']) }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">New Users This Month</h4>
                                <p class="text-xs text-gray-600">Recently registered</p>
                            </div>
                            <span class="text-2xl font-bold text-green-600">{{ number_format($userStats['new_users_this_month']) }}</span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-purple-50 p-4 rounded-lg text-center">
                                <p class="text-lg font-bold text-purple-600">{{ number_format($userStats['supervisors']) }}</p>
                                <p class="text-xs text-gray-600">Supervisors</p>
                            </div>
                            <div class="bg-orange-50 p-4 rounded-lg text-center">
                                <p class="text-lg font-bold text-orange-600">{{ number_format($userStats['members']) }}</p>
                                <p class="text-xs text-gray-600">Members</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Statistics Overview -->
       <!-- Project Statistics Overview -->
       <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Project Statistics Overview</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2h10a2 2 0 012 2v2M7 7V4a2 2 0 012-2h6a2 2 0 012 2v3"></path>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($projectStats['active_projects']) }}</p>
                        <p class="text-sm text-gray-600">Active Projects</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($projectStats['completed_projects']) }}</p>
                        <p class="text-sm text-gray-600">Completed Projects</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($projectStats['draft_projects']) }}</p>
                        <p class="text-sm text-gray-600">Draft Projects</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($projectStats['projects_this_month']) }}</p>
                        <p class="text-sm text-gray-600">Created This Month</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // User Growth Chart
            const userGrowthData = @json($userGrowthChart);
            const userLabels = userGrowthData.map(item => item.month);
            const userCounts = userGrowthData.map(item => item.count);

            const userGrowthCtx = document.getElementById('userGrowthChart');
            if (userGrowthCtx) {
                new Chart(userGrowthCtx, {
                    type: 'line',
                    data: {
                        labels: userLabels,
                        datasets: [{
                            label: 'New Users',
                            data: userCounts,
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5
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
                                        return context.parsed.y + ' new user' + (context.parsed.y !== 1 ? 's' : '');
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });
            }

            // Project Status Distribution Chart
            const statusData = @json($statusDistribution);
            const statusLabels = Object.keys(statusData);
            const statusValues = Object.values(statusData);
            
            const statusColors = {
                'draft': '#6B7280',
                'in_progress': '#3B82F6',
                'active': '#10B981',
                'completed': '#059669',
                'on_hold': '#F59E0B',
                'cancelled': '#EF4444'
            };

            const projectStatusCtx = document.getElementById('projectStatusChart');
            if (projectStatusCtx && statusLabels.length > 0) {
                new Chart(projectStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: statusLabels.map(label => 
                            label.charAt(0).toUpperCase() + label.slice(1).replace('_', ' ')
                        ),
                        datasets: [{
                            data: statusValues,
                            backgroundColor: statusLabels.map(status => statusColors[status] || '#6B7280'),
                            borderWidth: 3,
                            borderColor: '#ffffff',
                            hoverBorderWidth: 4,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '60%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 12
                                    },
                                    usePointStyle: true,
                                    pointStyle: 'circle'
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

            // Hub Performance Chart
            const hubPerformanceData = @json($hubPerformanceChart);
            const hubNames = hubPerformanceData.map(item => item.name);
            const hubProjects = hubPerformanceData.map(item => item.projects);
            const hubActivities = hubPerformanceData.map(item => item.activities);

            const hubPerformanceCtx = document.getElementById('hubPerformanceChart');
            if (hubPerformanceCtx && hubNames.length > 0) {
                new Chart(hubPerformanceCtx, {
                    type: 'bar',
                    data: {
                        labels: hubNames,
                        datasets: [
                            {
                                label: 'Projects',
                                data: hubProjects,
                                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                                borderColor: 'rgb(59, 130, 246)',
                                borderWidth: 1,
                                borderRadius: 4,
                                borderSkipped: false
                            },
                            {
                                label: 'Activities',
                                data: hubActivities,
                                backgroundColor: 'rgba(16, 185, 129, 0.8)',
                                borderColor: 'rgb(16, 185, 129)',
                                borderWidth: 1,
                                borderRadius: 4,
                                borderSkipped: false
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'rectRounded'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                cornerRadius: 8
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });
            }

            // Add some animation to stats cards
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
                    }
                });
            }, observerOptions);

            // Observe all cards
            document.querySelectorAll('.bg-white').forEach(card => {
                observer.observe(card);
            });
        });

        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</div>



</div>
