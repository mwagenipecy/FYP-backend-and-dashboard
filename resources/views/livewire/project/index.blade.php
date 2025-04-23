<div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Projects</h1>
                <p class="mt-1 text-sm text-gray-500">Manage and track all your organization's projects</p>
            </div>
            <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                New Project
            </button>
        </div>
        
        <!-- Search and Filters -->
        <div class="mt-8 bg-white rounded-lg shadow">
            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                    <div class="col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" wire:model.live="search" id="search" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Search by title or description">
                        </div>
                    </div>
                    
                    <div>
                        <label for="statusFilter" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="statusFilter" wire:model.live="statusFilter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">All Statuses</option>
                            <option value="draft">Draft</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="hubFilter" class="block text-sm font-medium text-gray-700">Hub</label>
                        <select id="hubFilter" wire:model.live="hubFilter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">All Hubs</option>
                            @foreach (DB::table('hubs')->get() as $hub )
                            
                          
                            <option value="{{ $hub->id }}">{{ $hub->name }}</option>
                            @endforeach
                           
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Projects List -->
        <div class="mt-8">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Project Card 1 -->

                @forelse ($projects as $project)

                <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-indigo-600 truncate"> @if( $project->idea) {{ $project->idea->idea_type }} @else  Technology  @endif  </h3>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($project->status == 'draft') bg-gray-100 text-gray-800 
                                @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800 
                                @elseif($project->status == 'completed') bg-green-100 text-green-800 
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>


                        </div>
                        <p class="mt-2 text-sm text-gray-500 line-clamp-2">
                            {{  $project->title }}
                        </p>
                        
                        <!-- Timeline Section -->
                        <div class="mt-4">
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span>{{  $project->created_at->format("Y-M") }} </span>
                                <span>Jun 30</span>
                            </div>


                            @if( $project->status=='in_progress')
                            <div class="mt-1 relative">
                                <div class="h-2 bg-gray-200 rounded">
                                    <div class="absolute top-0 left-0 h-2 bg-indigo-500 rounded" style="width: 45%"></div>
                                </div>
                                <div class="absolute -top-1 h-4 w-4 rounded-full bg-indigo-600 border-2 border-white" style="left: 45%; margin-left: -6px;"></div>
                            </div>

                            @elseif( $project->status=='draft')

                            <div class="mt-1 relative">
                                <div class="h-2 bg-gray-200 rounded">
                                    <div class="absolute top-0 left-0 h-2 bg-gray-400 rounded" style="width: 10%"></div>
                                </div>
                                <div class="absolute -top-1 h-4 w-4 rounded-full bg-gray-600 border-2 border-white" style="left: 10%; margin-left: -6px;"></div>
                            </div>

                            @elseif( $project->status=='completed')


                            <div class="mt-1 relative">
                                <div class="h-2 bg-gray-200 rounded">
                                    <div class="absolute top-0 left-0 h-2 bg-green-500 rounded" style="width: 100%"></div>
                                </div>
                                <div class="absolute -top-1 h-4 w-4 rounded-full bg-green-600 border-2 border-white" style="left: 100%; margin-left: -6px;"></div>
                            </div>
                            @endif 


                            <div class="mt-1 text-xs text-center text-gray-500">45% Complete</div>
                        </div>
                        
                        <div class="mt-4 flex items-center justify-between">
                          
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                @if($project->hub)

                                 {{ $project->hub->name }}

                                 @endif

                            </div>
                            <div class="text-sm text-gray-500">
                            {{ $project->users->count() }} Members
                            </div>



                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3 text-right">
                        <a href="{{ route('individual.project.list', $project->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View details</a>
                    </div>
                </div>

                @empty

                <div class="text-center py-6">
                    <p class="text-gray-500">No projects available at the moment. Please try adjusting your filters or create a new project.</p>
                    <button wire:click="createProject" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Create New Project
                    </button>
                </div>

                @endforelse






            </div>

            
            <!-- Pagination -->
            <div class="mt-8 flex items-center space-x-4 justify-end bg-white px-4 py-3 sm:px-6 shadow rounded-lg">

                    {{ $projects->links() }}


               
            </div>
        </div>
    </div>

</div>
