<div>



<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Navigation Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <button wire:click="showActivities" 
                            class="inline-flex items-center text-sm font-medium {{ $currentView === 'activities' ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Activities
                    </button>
                </li>
                
                @if($currentView !== 'activities' && isset($activity))
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500">{{ Str::limit($activity->name, 30) }}</span>
                    </div>
                </li>
                
                @if($currentView === 'questions')
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-indigo-600">Questions</span>
                    </div>
                </li>
                @elseif($currentView === 'responses')
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-indigo-600">Responses</span>
                    </div>
                </li>
                @elseif($currentView === 'individual_response' && isset($participant))
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <button wire:click="backToResponses" class="ml-1 text-sm font-medium text-gray-500 hover:text-indigo-600">Responses</button>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-indigo-600">{{ $participant->name }}</span>
                    </div>
                </li>
                @endif
                @endif
            </ol>
        </nav>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-6 rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Activities List View -->
        @if($currentView === 'activities')
        <div>
            <!-- Header -->
            <div class="mb-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-3xl font-bold leading-7 text-gray-900 sm:text-4xl sm:truncate">
                            Activity Management
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage your hub activities, questions, and participant responses
                        </p>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <a href="{{ route('activity.create') }}" 
                           class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Activity
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Filters</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="selectedHub" class="block text-sm font-medium text-gray-700 mb-1">Hub</label>
                            <select wire:model.live="selectedHub" id="selectedHub" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                                <option value="all">All Hubs</option>
                                @foreach($hubs as $hub)
                                    <option value="{{ $hub->id }}">{{ $hub->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="selectedStatus" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select wire:model.live="selectedStatus" id="selectedStatus" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                                <option value="all">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <div>
                            <label for="searchActivity" class="block text-sm font-medium text-gray-700 mb-1">Search Activities</label>
                            <input wire:model.live.debounce.300ms="searchActivity" type="text" id="searchActivity"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Search by activity name...">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activities Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($activities as $activity)
                    <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
                        <!-- Activity Header -->
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $activity->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $activity->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ ucfirst($activity->activity_type) }}
                                    </span>
                                </div>
                                
                                <!-- Action Dropdown -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" 
                                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                        <div class="py-1">
                                            <a href="{{ route('activity.edit', $activity->id) }}" 
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit Activity</a>
                                            <button wire:click="toggleActivityStatus({{ $activity->id }})" 
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                {{ $activity->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                            <button wire:click="duplicateActivity({{ $activity->id }})" 
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Duplicate
                                            </button>
                                            <button wire:click="exportActivityData({{ $activity->id }})" 
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Export Data
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Content -->
                        <div class="px-6 py-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $activity->name }}</h3>
                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($activity->description, 100) }}</p>
                            
                            <!-- Hub Info -->
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                {{ $activity->hub->name }}
                            </div>

                            <!-- Registration Window (if applicable) -->
                            @if($activity->activity_type === 'registration' && ($activity->registration_start || $activity->registration_end))
                            <div class="bg-blue-50 rounded-lg p-3 mb-4">
                                <h4 class="text-sm font-medium text-blue-900 mb-1">Registration Window</h4>
                                <div class="text-xs text-blue-700 space-y-1">
                                    @if($activity->registration_start)
                                    <div class="flex items-center">
                                        <span class="font-medium mr-2">Start:</span>
                                        {{ $activity->registration_start->format('M d, Y H:i A') }}
                                    </div>
                                    @endif
                                    @if($activity->registration_end)
                                    <div class="flex items-center">
                                        <span class="font-medium mr-2">End:</span>
                                        {{ $activity->registration_end->format('M d, Y H:i A') }}
                                    </div>
                                    @endif
                                    @if($activity->max_participants)
                                    <div class="flex items-center">
                                        <span class="font-medium mr-2">Max Participants:</span>
                                        {{ $activity->max_participants }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Statistics -->
                            <div class="grid grid-cols-3 gap-3 mb-4">
                                <div class="text-center">
                                    <div class="text-lg font-semibold text-gray-900">{{ $activity->questions_count ?? 0 }}</div>
                                    <div class="text-xs text-gray-500">Questions</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-semibold text-gray-900">{{ $activity->total_participants ?? 0 }}</div>
                                    <div class="text-xs text-gray-500">Participants</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-semibold text-gray-900">{{ $activity->total_responses ?? 0 }}</div>
                                    <div class="text-xs text-gray-500">Responses</div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Actions -->
                        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                            <div class="flex space-x-2">
                                <button wire:click="showActivityQuestions({{ $activity->id }})" 
                                        class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Questions
                                </button>
                                <button wire:click="showActivityResponses({{ $activity->id }})" 
                                        class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Responses
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No activities found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating your first activity.</p>
                            <div class="mt-6">
                                <a href="{{ route('activity.create') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Create Activity
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($activities->hasPages())
            <div class="mt-6">
                {{ $activities->links() }}
            </div>
            @endif
        </div>

        <!-- Questions View -->
        @elseif($currentView === 'questions' && isset($activity))
        <div>
            <!-- Activity Header -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $activity->name }}</h2>
                            <p class="mt-1 text-sm text-gray-500">{{ $activity->description }}</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('activity.edit', $activity->id) }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Activity
                            </a>
                            <button wire:click="showActivityResponses({{ $activity->id }})" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                View Responses
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Activity Details -->
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="flex items-center">
                            <svg class="mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-sm text-gray-600">{{ $activity->hub->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a.997.997 0 01-1.414 0l-7-7A1.997 1.997 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span class="text-sm text-gray-600">{{ ucfirst($activity->activity_type) }}</span>
                        </div>
                        @if($activity->registration_start)
                        <div class="flex items-center">
                            <svg class="mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm text-gray-600">Starts: {{ $activity->registration_start->format('M d, Y') }}</span>
                        </div>
                        @endif
                        @if($activity->registration_end)
                        <div class="flex items-center">
                            <svg class="mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm text-gray-600">Ends: {{ $activity->registration_end->format('M d, Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Questions List -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Questions ({{ $questions->count() }})
                    </h3>
                </div>

                @if($questions->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($questions as $question)
                            <div class="px-6 py-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-800 text-sm font-medium">
                                                {{ $question->pivot->display_order }}
                                            </span>
                                            <h4 class="text-lg font-medium text-gray-900">{{ $question->question }}</h4>
                                            @if($question->pivot->is_required)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                    Required
                                                </span>
                                            @endif
                                        </div>
                                        
                                        @if($question->description)
                                            <p class="text-sm text-gray-600 mb-3 ml-9">{{ $question->description }}</p>
                                        @endif

                                        <div class="ml-9 flex items-center space-x-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $question->type_display }}
                                            </span>
                                            
                                            @if($question->options)
                                                <div class="text-sm text-gray-500">
                                                    <span class="font-medium">Options:</span> 
                                                    {{ implode(', ', array_slice($question->options, 0, 3)) }}{{ count($question->options) > 3 ? '...' : '' }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No questions found</h3>
                        <p class="mt-1 text-sm text-gray-500">This activity doesn't have any questions yet.</p>
                        <div class="mt-6">
                            <a href="{{ route('activity.edit', $activity->id) }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Add Questions
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Responses View -->
        @elseif($currentView === 'responses' && isset($activity))
        <div>
            <!-- Activity Header with Stats -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $activity->name }} - Responses</h2>
                            <p class="mt-1 text-sm text-gray-500">{{ $activity->description }}</p>
                        </div>
                        <div class="flex space-x-3">
                            <button wire:click="showActivityQuestions({{ $activity->id }})" 
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                View Questions
                            </button>
                            <button wire:click="exportActivityData({{ $activity->id }})" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Export Data
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="px-6 py-4">
                    <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-indigo-600">{{ $stats['total_questions'] ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Questions</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $stats['unique_participants'] ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Participants</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $stats['total_responses'] ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Total Responses</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending_reviews'] ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Pending</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $stats['approved_participants'] ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Approved</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">{{ $stats['rejected_participants'] ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Rejected</div>
                        </div>
                    </div>

                    @if(isset($registrationStats) && $activity->activity_type === 'registration')
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Registration Details</h4>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                            <div class="text-center">
                                <div class="text-lg font-bold text-blue-600">{{ $registrationStats['total_registrations'] ?? 0 }}</div>
                                <div class="text-xs text-gray-500">Total Registrations</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-yellow-600">{{ $registrationStats['pending_registrations'] ?? 0 }}</div>
                                <div class="text-xs text-gray-500">Pending</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-green-600">{{ $registrationStats['approved_registrations'] ?? 0 }}</div>
                                <div class="text-xs text-gray-500">Approved</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-red-600">{{ $registrationStats['rejected_registrations'] ?? 0 }}</div>
                                <div class="text-xs text-gray-500">Rejected</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-purple-600">{{ $registrationStats['available_slots'] ?? 'Unlimited' }}</div>
                                <div class="text-xs text-gray-500">Available Slots</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Filter Participants</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="selectedResponseStatus" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select wire:model.live="selectedResponseStatus" id="selectedResponseStatus" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                                <option value="all">All Statuses</option>
                                <option value="submitted">Pending Review</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>

                        <div>
                            <label for="searchParticipant" class="block text-sm font-medium text-gray-700 mb-1">Search Participants</label>
                            <input wire:model.live.debounce.300ms="searchParticipant" type="text" id="searchParticipant"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Search by name or email...">
                        </div>

                        <div>
                            <label for="dateFrom" class="block text-sm font-medium text-gray-700 mb-1">Response Date</label>
                            <input wire:model.live="dateFrom" type="date" id="dateFrom"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Participants List -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Participant Responses
                    </h3>
                </div>

                @if($participants->count() > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach($participants as $participant)
                            @php
                                $firstResponse = $participant->activityResponses->first();
                                $responseStatus = $firstResponse ? $firstResponse->status : 'submitted';
                                $hasReview = $firstResponse && $firstResponse->reviewed_at;
                            @endphp
                            <li class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <!-- Avatar -->
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                <span class="text-sm font-medium text-indigo-700">
                                                    {{ substr($participant->name, 0, 1) }}{{ substr(explode(' ', $participant->name)[1] ?? '', 0, 1) }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Participant Info -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-3">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $participant->name }}
                                                </p>
                                                @switch($responseStatus)
                                                    @case('submitted')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            Pending Review
                                                        </span>
                                                        @break
                                                    @case('approved')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Approved
                                                        </span>
                                                        @break
                                                    @case('rejected')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Rejected
                                                        </span>
                                                        @break
                                                @endswitch
                                            </div>
                                            <p class="text-sm text-gray-500">{{ $participant->email }}</p>
                                            <div class="mt-1 flex items-center space-x-4 text-xs text-gray-500">
                                                <span>{{ $participant->response_count }} responses</span>
                                                @if($firstResponse)
                                                    <span>Submitted: {{ $firstResponse->answered_at->format('M d, Y H:i A') }}</span>
                                                @endif
                                                @if($hasReview && $firstResponse->reviewer)
                                                    <span>Reviewed by: {{ $firstResponse->reviewer->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                 



                                    <div class="flex space-x-2">
                                        <button wire:click="viewIndividualResponse({{ $participant->id }})" 
                                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            View Response
                                        </button>
                                        <button wire:click="approveResponse({{ $participant->id }})" 
                                                class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Approve
                                        </button>
                                        <button wire:click="rejectResponse({{ $participant->id }})" 
                                                class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Reject
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else

                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No participant responses found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your filters or check back later.</p>
                    </div>
                @endif


                @endif 


            </div>
        </div>
    </div>





</div>
