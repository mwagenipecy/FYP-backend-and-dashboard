<div>
<div>
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <h3 class="text-2xl leading-6 font-medium text-gray-900">Projects</h3>
        </div>
        
        <!-- Search and Filters -->
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mt-5">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
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
                        <option value="draft">Draft</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                
                <div>
                    <label for="hubFilter" class="block text-sm font-medium text-gray-700">Hub</label>
                    <select id="hubFilter" wire:model="hubFilter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">All Hubs</option>
                        @foreach($hubs as $hub)
                            <option value="{{ $hub->id }}">{{ $hub->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>


        <livewire:project.create />
        
        <!-- Projects List -->
        <div class="mt-5 bg-white shadow overflow-hidden sm:rounded-md">
            @if ($projects->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach ($projects as $project)
                        <li>
                            <a href="{{ route('projects.show', $project->id) }}" class="block hover:bg-gray-50">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <p class="text-sm font-medium text-indigo-600 truncate">{{ $project->title }}</p>
                                            <div class="ml-4 flex-shrink-0">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($project->status == 'draft') bg-gray-100 text-gray-800 
                                                    @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800 
                                                    @elseif($project->status == 'completed') bg-green-100 text-green-800 
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Created {{ $project->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            @if($project->hub)
                                                <p class="flex items-center text-sm text-gray-500">
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $project->hub->name }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $project->users->count() }} Members
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                
                <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                    {{ $projects->links() }}
                </div>
            @else
                <div class="px-4 py-5 sm:p-6 text-center">
                    <p class="text-gray-500">No projects found.</p>
                </div>
            @endif
        </div>
    </div>
</div>

</div>
