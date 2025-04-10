<div>
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <h3 class="text-2xl leading-6 font-medium text-gray-900">Project Ideas</h3>
            <div class="mt-3 sm:mt-0 sm:ml-4">
                <a href="{{ route('project-ideas.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Submit New Idea
                </a>
            </div>
        </div>
        
        <!-- Search and Filters -->
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mt-5">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                    <div class="mt-1">
                        <input type="text" wire:model.debounce.300ms="search" id="search" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Search by title or description">
                    </div>
                </div>
                
                <div>
                    <label for="statusFilter" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="statusFilter" wire:model="statusFilter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">All Statuses</option>
                        <option value="submitted">Submitted</option>
                        <option value="under_review">Under Review</option>
                        <option value="needs_qualification">Needs Qualification</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Project Ideas List -->
        <div class="mt-5 bg-white shadow overflow-hidden sm:rounded-md">
            @if ($projectIdeas->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach ($projectIdeas as $idea)
                        <li>
                            <a href="{{ route('project-ideas.show', $idea->id) }}" class="block hover:bg-gray-50">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <p class="text-sm font-medium text-indigo-600 truncate">{{ $idea->title }}</p>
                                            <div class="ml-4 flex-shrink-0">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($idea->status == 'submitted') bg-blue-100 text-blue-800 
                                                    @elseif($idea->status == 'under_review') bg-yellow-100 text-yellow-800 
                                                    @elseif($idea->status == 'needs_qualification') bg-purple-100 text-purple-800 
                                                    @elseif($idea->status == 'approved') bg-green-100 text-green-800 
                                                    @elseif($idea->status == 'rejected') bg-red-100 text-red-800 
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $idea->status)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Submitted {{ $idea->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $idea->user->name }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                
                <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                    {{ $projectIdeas->links() }}
                </div>
            @else
                <div class="px-4 py-5 sm:p-6 text-center">
                    <p class="text-gray-500">No project ideas found.</p>
                </div>
            @endif
        </div>
    </div>
</div>