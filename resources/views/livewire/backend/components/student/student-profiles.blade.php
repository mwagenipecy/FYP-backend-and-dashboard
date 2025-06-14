<div>
    
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg shadow-lg text-white p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">Student Profiles Dashboard</h1>
                <p class="text-indigo-100">Comprehensive view of all students, their skills, and achievements</p>
            </div>
            <div class="flex space-x-3">
                <button wire:click="refreshData" class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg hover:bg-opacity-30 transition-colors">
                    <i class="fas fa-refresh mr-2"></i> Refresh
                </button>
                <button wire:click="exportStudents" class="bg-white text-indigo-600 px-4 py-2 rounded-lg hover:bg-gray-100 font-semibold transition-colors">
                    <i class="fas fa-download mr-2"></i> Export Data
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Students -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Students</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalStudents }}</p>
                    <p class="text-sm text-gray-500 mt-1">Registered users</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-graduation-cap text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Active Students -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Students</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $activeStudents }}</p>
                    <p class="text-sm text-gray-500 mt-1">With projects</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-user-check text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Projects -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Student Projects</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalProjects }}</p>
                    <p class="text-sm text-gray-500 mt-1">All time</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-project-diagram text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Hub Participation -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Hub Connections</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $hubConnections }}</p>
                    <p class="text-sm text-gray-500 mt-1">Student-hub links</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-network-wired text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Filter & Search Students</h3>
            <div class="flex space-x-2">
                <button wire:click="resetFilters" class="text-gray-600 hover:text-gray-800 text-sm">
                    <i class="fas fa-undo mr-1"></i> Reset Filters
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Search -->
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input wire:model.live="search" type="text" placeholder="Search students..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Level Filter -->
            <div class="relative">
                <select wire:model.live="levelFilter" class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Levels</option>
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
            </div>

            <!-- Field Type Filter -->
            <div class="relative">
                <select wire:model.live="fieldTypeFilter" class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Fields</option>
                    <option value="technology">Technology</option>
                    <option value="business">Business</option>
                    <option value="design">Design</option>
                    <option value="science">Science</option>
                    <option value="engineering">Engineering</option>
                    <option value="other">Other</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
            </div>

            <!-- Project Status Filter -->
            <div class="relative">
                <select wire:model.live="projectStatusFilter" class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Students</option>
                    <option value="active">With Active Projects</option>
                    <option value="completed">With Completed Projects</option>
                    <option value="none">No Projects</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
            </div>

            <!-- Hub Filter -->
            <div class="relative">
                <select wire:model.live="hubFilter" class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Hubs</option>
                    @foreach($hubs as $hub)
                        <option value="{{ $hub->id }}">{{ $hub->name }}</option>
                    @endforeach
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Students Grid/List Toggle -->
    <div class="flex justify-between items-center">
        <div class="text-sm text-gray-600">
            Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} students
        </div>
        <div class="flex space-x-2">
            <button wire:click="$set('viewMode', 'grid')" 
                class="px-3 py-2 rounded-lg {{ $viewMode === 'grid' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }} transition-colors">
                <i class="fas fa-th-large"></i>
            </button>
            <button wire:click="$set('viewMode', 'list')" 
                class="px-3 py-2 rounded-lg {{ $viewMode === 'list' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }} transition-colors">
                <i class="fas fa-list"></i>
            </button>
        </div>
    </div>

    <!-- Students Display -->
    @if($viewMode === 'grid')
        <!-- Grid View -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($students as $student)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 overflow-hidden">
                <!-- Student Header -->
                <div class="relative p-6 pb-0">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <img class="h-16 w-16 rounded-full object-cover border-4 border-white shadow-md" 
                                 src="{{ $student->profile_photo_path ? asset('storage/' . $student->profile_photo_path) : asset('images/default-avatar.png') }}" 
                                 alt="{{ $student->name }}">
                            @if($student->projects_count > 0)
                                <div class="absolute -top-1 -right-1 bg-green-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold">
                                    {{ $student->projects_count }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $student->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $student->email }}</p>
                            @if($student->regno)
                                <p class="text-xs text-gray-400">Reg: {{ $student->regno }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Student Stats -->
                <div class="p-6 pt-4">
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div class="text-center">
                            <div class="text-lg font-bold text-indigo-600">{{ $student->projects_count }}</div>
                            <div class="text-xs text-gray-500">Projects</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-green-600">{{ $student->hubs_count }}</div>
                            <div class="text-xs text-gray-500">Hubs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-purple-600">{{ $student->ideas_count }}</div>
                            <div class="text-xs text-gray-500">Ideas</div>
                        </div>
                    </div>

                    <!-- Skills Preview -->
                    @if($student->skills && count($student->skills) > 0)
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach(array_slice($student->skills, 0, 3) as $skill)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                                @if(count($student->skills) > 3)
                                    <span class="text-xs text-gray-500">+{{ count($student->skills) - 3 }} more</span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Latest Project -->
                    @if($student->latest_project)
                        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-900 mb-1">Latest Project</h4>
                            <p class="text-sm text-gray-600 truncate">{{ $student->latest_project->title }}</p>
                            <p class="text-xs text-gray-500">{{ $student->latest_project->created_at->diffForHumans() }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex space-x-2">
                        <button wire:click="viewStudentProfile({{ $student->id }})" 
                            class="flex-1 bg-indigo-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-user mr-1"></i> View Profile
                        </button>
                        <button wire:click="viewStudentProjects({{ $student->id }})" 
                            class="bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm hover:bg-gray-300 transition-colors">
                            <i class="fas fa-project-diagram"></i>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-user-graduate text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No students found</h3>
                <p class="text-gray-500">Try adjusting your search criteria or filters.</p>
            </div>
            @endforelse
        </div>
    @else
        <!-- List View -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th wire:click="sortBy('name')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            Student Details
                            @if($sortField === 'name')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @else
                                <i class="fas fa-sort text-gray-400 ml-1"></i>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Skills & Field
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Projects & Hubs
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Latest Activity
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($students as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-12 w-12 flex-shrink-0">
                                    <img class="h-12 w-12 rounded-full object-cover" 
                                         src="{{ $student->profile_photo_path ? asset('storage/' . $student->profile_photo_path) : asset('images/default-avatar.png') }}" 
                                         alt="{{ $student->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $student->email }}</div>
                                    @if($student->regno)
                                        <div class="text-xs text-gray-400">Reg: {{ $student->regno }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-w-xs">
                                @if($student->fieldType)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mb-2">
                                        {{ ucfirst($student->fieldType) }}
                                    </span>
                                @endif
                                @if($student->skills && count($student->skills) > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(array_slice($student->skills, 0, 4) as $skill)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                        @if(count($student->skills) > 4)
                                            <span class="text-xs text-gray-500">+{{ count($student->skills) - 4 }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">No skills listed</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col space-y-1 text-sm">
                                <div class="flex items-center">
                                    <i class="fas fa-project-diagram text-purple-500 w-4"></i>
                                    <span class="ml-2 font-medium">{{ $student->projects_count }}</span>
                                    <span class="ml-1 text-gray-500">Projects</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-building text-blue-500 w-4"></i>
                                    <span class="ml-2 font-medium">{{ $student->hubs_count }}</span>
                                    <span class="ml-1 text-gray-500">Hubs</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-lightbulb text-yellow-500 w-4"></i>
                                    <span class="ml-2 font-medium">{{ $student->ideas_count }}</span>
                                    <span class="ml-1 text-gray-500">Ideas</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($student->latest_project)
                                <div class="max-w-xs">
                                    <div class="text-sm font-medium text-gray-900 truncate">{{ $student->latest_project->title }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($student->latest_project->description, 50) }}</div>
                                    <div class="text-xs text-gray-400">{{ $student->latest_project->created_at->diffForHumans() }}</div>
                                </div>
                            @else
                                <span class="text-gray-400 text-sm">No recent activity</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button wire:click="viewStudentProfile({{ $student->id }})" 
                                        class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50" 
                                        title="View Profile">
                                    <i class="fas fa-user"></i>
                                </button>
                                <button wire:click="viewStudentProjects({{ $student->id }})" 
                                        class="text-green-600 hover:text-green-900 p-1 rounded hover:bg-green-50" 
                                        title="View Projects">
                                    <i class="fas fa-project-diagram"></i>
                                </button>
                                <button wire:click="messageStudent({{ $student->id }})" 
                                        class="text-purple-600 hover:text-purple-900 p-1 rounded hover:bg-purple-50" 
                                        title="Send Message">
                                    <i class="fas fa-envelope"></i>
                                </button>
                                <div class="relative">
                                    <button wire:click="toggleStudentActions({{ $student->id }})" 
                                            class="text-gray-400 hover:text-gray-600 p-1 rounded hover:bg-gray-50">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    @if(isset($showStudentActions[$student->id]))
                                    <div class="absolute right-0 top-full mt-1 w-48 bg-white rounded-md shadow-lg z-50 border">
                                        <div class="py-1">
                                            <button wire:click="assignToHub({{ $student->id }})" 
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-plus-circle mr-2"></i> Assign to Hub
                                            </button>
                                            <button wire:click="viewAnalytics({{ $student->id }})" 
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-chart-line mr-2"></i> View Analytics
                                            </button>
                                            <button wire:click="editStudent({{ $student->id }})" 
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-edit mr-2"></i> Edit Profile
                                            </button>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-user-graduate text-gray-300 text-4xl mb-4"></i>
                                <p class="text-lg font-medium text-gray-900 mb-2">No students found</p>
                                <p class="text-sm text-gray-500">Try adjusting your search criteria or filters.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    <!-- Pagination -->
    @if($students->hasPages())
    <div class="flex justify-between items-center">
        <div class="text-sm text-gray-600">
            Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} results
        </div>
        <div>
            {{ $students->links() }}
        </div>
    </div>
    @endif

    <!-- Student Profile Modal -->
    @if($showProfileModal && $selectedStudent)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeProfileModal">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-4xl w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900">Student Profile - {{ $selectedStudent->name }}</h3>
                <button wire:click="closeProfileModal" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Student Info -->
                <div class="lg:col-span-1">
                    <div class="text-center mb-6">
                        <img class="h-32 w-32 rounded-full object-cover mx-auto mb-4" 
                             src="{{ $selectedStudent->profile_photo_path ? asset('storage/' . $selectedStudent->profile_photo_path) : asset('images/default-avatar.png') }}" 
                             alt="{{ $selectedStudent->name }}">
                        <h4 class="text-xl font-medium text-gray-900">{{ $selectedStudent->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $selectedStudent->email }}</p>
                        @if($selectedStudent->regno)
                            <p class="text-sm text-gray-400">Reg: {{ $selectedStudent->regno }}</p>
                        @endif
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Field Type</label>
                            <p class="text-sm text-gray-900">{{ $selectedStudent->fieldType ? ucfirst($selectedStudent->fieldType) : 'Not specified' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Level</label>
                            <p class="text-sm text-gray-900">{{ $selectedStudent->level->name ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Member Since</label>
                            <p class="text-sm text-gray-900">{{ $selectedStudent->created_at ?->format('M d, Y') }}</p>
                        </div>
                        
                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-indigo-600">{{ $selectedStudent->projects_count }}</div>
                                <div class="text-xs text-gray-500">Projects</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">{{ $selectedStudent->hubs_count }}</div>
                                <div class="text-xs text-gray-500">Hubs</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Skills and Projects -->
                <div class="lg:col-span-2">
                    <!-- Skills Section -->
                    <div class="mb-6">
                        <h5 class="text-lg font-medium text-gray-900 mb-3">Skills & Abilities</h5>
                        @if($selectedStudent->skills && count($selectedStudent->skills) > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($selectedStudent->skills as $skill)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No skills listed yet.</p>
                        @endif
                    </div>

                    <!-- Projects Section -->
                    <div>
                        <h5 class="text-lg font-medium text-gray-900 mb-3">Recent Projects</h5>
                        <div class="space-y-4 max-h-64 overflow-y-auto">
                            @forelse($selectedStudent->recent_projects ?? [] as $project)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h6 class="font-medium text-gray-900">{{ $project->title }}</h6>
                                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($project->description, 100) }}</p>
                                        <div class="flex items-center mt-2 space-x-4">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $project->status === 'active' ? 'bg-green-100 text-green-800' : ($project->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($project->status) }}
                                            </span>
                                            <span class="text-xs text-gray-500">{{ $project->created_at->format('M d, Y') }}</span>
                                            @if($project->hub)
                                                <span class="text-xs text-blue-600">{{ $project->hub->name }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <button wire:click="viewProject({{ $project->id }})" 
                                            class="text-blue-600 hover:text-blue-800 text-sm ml-4">
                                        <i class="fas fa-external-link-alt"></i>
                                    </button>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">No projects found</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Hubs Section -->
                    <div class="mt-6">
                        <h5 class="text-lg font-medium text-gray-900 mb-3">Hub Participation</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($selectedStudent->student_hubs ?? [] as $hub)
                            <div class="border border-gray-200 rounded-lg p-3">
                                <div class="flex items-center space-x-3">
                                    <img class="h-10 w-10 rounded-full object-cover" 
                                         src="{{ $hub->image ? asset('storage/' . $hub->image) : asset('images/default-hub.png') }}" 
                                         alt="{{ $hub->name }}">
                                    <div>
                                        <h6 class="font-medium text-gray-900">{{ $hub->name }}</h6>
                                        <p class="text-xs text-gray-500">{{ $hub->projects_in_hub }} projects</p>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 col-span-2 text-center py-4">Not participating in any hubs</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-6 pt-6 border-t border-gray-200 space-x-3">
                <button wire:click="editStudent({{ $selectedStudent->id }})" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    <i class="fas fa-edit mr-2"></i> Edit Profile
                </button>
                <button wire:click="closeProfileModal" 
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Close
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Loading Indicator -->
    <div wire:loading class="fixed inset-0 bg-black bg-opacity-25 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-4 flex items-center space-x-2">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div>
            <span class="text-gray-700">Loading...</span>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session()->has('message'))
    <div id="success-notification" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('message') }}</span>
        </div>
    </div>
    <script>
        setTimeout(function() {
            const notification = document.getElementById('success-notification');
            if (notification) {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }
        }, 3000);
    </script>
    @endif

    @if(session()->has('error'))
    <div id="error-notification" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    <script>
        setTimeout(function() {
            const notification = document.getElementById('error-notification');
            if (notification) {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }
        }, 3000);
    </script>
    @endif
</div>

</div>
