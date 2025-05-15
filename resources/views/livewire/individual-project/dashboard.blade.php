<div>



<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Project Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $project->title }}</h1>
        <p class="mt-2 text-gray-600">{{ $project->description ?? 'Project dashboard and tracking' }}</p>
        <div class="mt-4 flex items-center space-x-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                {{ $project->status === 'active' ? 'bg-green-100 text-green-800' : 
                   ($project->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                {{ ucfirst($project->status) }}
            </span>
            <span class="text-sm text-gray-500">
                Current Stage: {{ $projectStats['current_phase'] }}
            </span>
        </div>
    </div>

    <!-- Project Overview Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Progress Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Overall Progress</dt>
                            <dd>
                                <div class="text-lg font-medium text-gray-900">{{ $projectStats['progress_percentage'] }}% Complete</div>
                                <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $projectStats['progress_percentage'] }}%"></div>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tasks</dt>
                            <dd>
                                <div class="text-lg font-medium text-gray-900">
                                    {{ $projectStats['tasks_completed'] }} / {{ $projectStats['tasks_total'] }} Complete
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">View all tasks</a>
                </div>
            </div>
        </div>

        <!-- Team Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Team</dt>
                            <dd>
                                <div class="text-lg font-medium text-gray-900">{{ $teamMembers->count() }} Members</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">View team</a>
                </div>
            </div>
        </div>

        <!-- Documents Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2H8m0-10H6a2 2 0 00-2 2v10a2 2 0 002 2h2m8 0V9h-4a1 1 0 01-1-1V4H8" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Documents</dt>
                            <dd>
                                <div class="text-lg font-medium text-gray-900">
                                    {{ $projectStats['documents_approved'] }} / {{ $projectStats['documents_total'] }} Approved
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">View documents</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Lifecycle -->
    <div class="mb-8">
        <h2 class="text-lg leading-6 font-medium text-gray-900 mb-4">Project Phases</h2>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-6">
                <!-- Phases Progress Bar -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-2">
                        @foreach($phases as $index => $phase)
                            <div class="flex-1 {{ $index > 0 ? 'ml-4' : '' }}">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-full flex items-center justify-center
                                            {{ $phase->status === 'completed' ? 'bg-green-500' : 
                                               ($phase->status === 'in_progress' ? 'bg-indigo-500' : 'bg-gray-300') }}">
                                            @if($phase->status === 'completed')
                                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @else
                                                <span class="text-xs font-medium text-white">{{ $index + 1 }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="ml-2 flex-1">
                                        <p class="text-sm font-medium 
                                            {{ $phase->status === 'completed' ? 'text-green-600' : 
                                               ($phase->status === 'in_progress' ? 'text-indigo-600' : 'text-gray-500') }}">
                                            {{ $phase->name }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $phase->completion_percentage }}% complete</p>
                                    </div>
                                </div>
                                @if($index < $phases->count() - 1)
                                    <div class="mt-3 h-1 bg-gray-200 rounded-full">
                                        <div class="h-1 bg-{{ $phase->status === 'completed' ? 'green' : 'gray' }}-500 rounded-full transition-all duration-300"
                                             style="width: {{ $phase->status === 'completed' ? '100' : '0' }}%"></div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Detailed Phase Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ $phases->count() }} gap-4">
                    @foreach($phases as $phase)
                        <div class="border rounded-lg p-4 {{ $phase->status === 'in_progress' ? 'border-indigo-200 bg-indigo-50' : 'border-gray-200' }}">
                            <h3 class="font-medium text-gray-900 mb-2">{{ $phase->name }}</h3>
                            <p class="text-sm text-gray-600 mb-3">{{ $phase->description }}</p>
                            
                            <!-- Stages in this phase -->
                            <div class="space-y-2">
                                @foreach($phase->stages as $stage)
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-700">{{ $stage->name }}</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            {{ $stage->status === 'completed' ? 'bg-green-100 text-green-800' :
                                               ($stage->status === 'in_progress' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst(str_replace('_', ' ', $stage->status)) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Upcoming Deadlines -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Recent Activity -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Activity</h3>
            </div>
            @if($recentActivities->isEmpty())
                <div class="p-4 text-center text-gray-500">
                    <p>No recent activities</p>
                </div>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($recentActivities as $activity)
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center">
                                        <span class="text-xs font-medium text-white">
                                            {{ substr($activity->user->name ?? 'System', 0, 2) }}
                                        </span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $activity->user->name ?? 'System' }}</p>
                                        <p class="text-sm text-gray-500">{{ $activity->name }}</p>
                                        @if($activity->description)
                                            <p class="text-xs text-gray-400">{{ Str::limit($activity->description, 50) }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">{{ $activity->created_at->diffForHumans() }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Upcoming Deadlines -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Upcoming Deadlines</h3>
            </div>
            @if($upcomingDeadlines->isEmpty())
                <div class="p-4 text-center text-gray-500">
                    <p>No upcoming deadlines</p>
                </div>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($upcomingDeadlines as $deadline)
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $deadline->name }}</p>
                                    <p class="text-sm text-gray-500">Due: {{ $deadline->end_date->format('M d, Y') }}</p>
                                    @if($deadline->description)
                                        <p class="text-xs text-gray-400">{{ Str::limit($deadline->description, 60) }}</p>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-500">
                                    @if($deadline->days_left > 0)
                                        <span class="text-green-600">{{ $deadline->days_left }} days left</span>
                                    @elseif($deadline->days_left == 0)
                                        <span class="text-yellow-600">Due today</span>
                                    @else
                                        <span class="text-red-600">{{ abs($deadline->days_left) }} days overdue</span>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <!-- Recent Documents -->
    @if($documents->isNotEmpty())
        <div class="mt-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Documents</h3>
                </div>
                <ul class="divide-y divide-gray-200">
                    @foreach($documents as $document)
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $document->title }}</p>
                                        <p class="text-sm text-gray-500">
                                            Uploaded by {{ Optional($document->uploadedBy)->name }} • {{ $document->created_at->diffForHumans() }}
                                        </p>
                                        <p class="text-xs text-gray-400">Stage: {{ $document->stage->name }}</p>
                                    </div>
                                </div>
                                <div class="text-sm">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        {{ $document->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $document->is_approved ? 'Approved' : 'Pending Review' }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>



</div>
