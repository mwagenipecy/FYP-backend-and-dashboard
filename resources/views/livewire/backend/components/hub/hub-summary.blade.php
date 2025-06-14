<div>
<div class="space-y-6">
    <!-- Hub Header Information -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg text-white p-6">
        <div class="flex justify-between items-start">
            <div class="flex items-center space-x-4">
                <div class="h-20 w-20 flex-shrink-0">
                    <img class="h-20 w-20 rounded-full object-cover border-4 border-white" 
                         src="{{ $selectedHub->image ? asset('storage/' . $selectedHub->image) : asset('images/default-hub.png') }}" 
                         alt="{{ $selectedHub->name }}">
                </div>
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ $selectedHub->name }}</h1>
                    <p class="text-blue-100 mb-1">{{ $selectedHub->email }}</p>
                    <p class="text-blue-100">{{ $selectedHub->phone_number }}</p>
                    <div class="flex items-center mt-2">
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $selectedHub->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($selectedHub->status) }}
                        </span>
                        @if($selectedHub->supervisor)
                            <span class="ml-3 text-blue-100">
                                <i class="fas fa-user-tie mr-1"></i>
                                Supervised by {{ $selectedHub->supervisor->name }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button wire:click="editHub" class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg hover:bg-opacity-30 transition-colors mb-2">
                    <i class="fas fa-edit mr-2"></i> Edit Hub
                </button>
                <div class="text-sm text-blue-100">
                    Created {{ $selectedHub->created_at->format('M d, Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Hub Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Members -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Members</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalMembers }}</p>
                    <p class="text-sm text-gray-500 mt-1">Active participants</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-users text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Active Projects -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Projects</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $activeProjects }}</p>
                    <p class="text-sm text-gray-500 mt-1">Currently running</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-project-diagram text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Completed Projects -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Completed Projects</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $completedProjects }}</p>
                    <p class="text-sm text-gray-500 mt-1">Successfully finished</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-check-circle text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Ideas -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pending Ideas</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $pendingIdeas }}</p>
                    <p class="text-sm text-gray-500 mt-1">Awaiting review</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-lightbulb text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Hub Description and Actions -->
    @if($selectedHub->description || $selectedHub->address)
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Hub Information</h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @if($selectedHub->description)
            <div>
                <h4 class="font-medium text-gray-700 mb-2">Description</h4>
                <p class="text-gray-600">{{ $selectedHub->description }}</p>
            </div>
            @endif
            @if($selectedHub->address)
            <div>
                <h4 class="font-medium text-gray-700 mb-2">Address</h4>
                <p class="text-gray-600">{{ $selectedHub->address }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Members Management Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Hub Members</h3>
                    <p class="text-sm text-gray-500">Users with projects in this hub</p>
                </div>
                <div class="flex space-x-3">
                    <div class="relative">
                        <input wire:model.live="memberSearch" type="text" placeholder="Search members..." 
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                    </div>
                    <select wire:model.live="projectStatusFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Projects</option>
                        <option value="active">Active Projects</option>
                        <option value="completed">Completed Projects</option>
                        <option value="draft">Draft Projects</option>
                    </select>
                    <button wire:click="showAddMemberModal" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm transition-colors">
                        <i class="fas fa-user-plus mr-1"></i> Add Member
                    </button>
                    <button wire:click="exportMembers" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm transition-colors">
                        <i class="fas fa-download mr-1"></i> Export
                    </button>
                </div>
            </div>
        </div>

        <!-- Members Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th wire:click="sortBy('name')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            Member Details
                            @if($sortField === 'name')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @else
                                <i class="fas fa-sort text-gray-400 ml-1"></i>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Latest Project
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Project Statistics
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role & Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($hubMembers as $member)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-12 w-12 flex-shrink-0">
                                    <img class="h-12 w-12 rounded-full object-cover" 
                                         src="{{ $member->profile_photo_path ? asset('storage/' . $member->profile_photo_path) : asset('images/default-avatar.png') }}" 
                                         alt="{{ $member->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $member->email }}</div>
                                    @if($member->regno)
                                        <div class="text-xs text-gray-400">Reg: {{ $member->regno }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($member->latest_project)
                                <div class="max-w-xs">
                                    <div class="text-sm font-medium text-gray-900 truncate">{{ $member->latest_project->title }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($member->latest_project->description, 60) }}</div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $member->latest_project->status === 'active' ? 'bg-green-100 text-green-800' : ($member->latest_project->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($member->latest_project->status) }}
                                        </span>
                                        <span class="ml-2">{{ $member->latest_project->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-400 text-sm">No projects yet</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col space-y-1 text-sm">
                                <div class="flex items-center">
                                    <i class="fas fa-project-diagram text-blue-500 w-4"></i>
                                    <span class="ml-2 font-medium">{{ $member->projects_count }}</span>
                                    <span class="ml-1 text-gray-500">Total</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-play-circle text-green-500 w-4"></i>
                                    <span class="ml-2 font-medium">{{ $member->active_projects_count }}</span>
                                    <span class="ml-1 text-gray-500">Active</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-purple-500 w-4"></i>
                                    <span class="ml-2 font-medium">{{ $member->completed_projects_count }}</span>
                                    <span class="ml-1 text-gray-500">Completed</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col space-y-2">
                                @if($member->user_role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $member->user_role }}
                                    </span>
                                @endif
                                <span class="text-xs text-gray-500">
                                    Member since {{ $member->first_project_date ? $member->first_project_date->format('M Y') : 'Unknown' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button wire:click="viewMemberDetails({{ $member->id }})" 
                                        class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50" 
                                        title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button wire:click="viewMemberProjects({{ $member->id }})" 
                                        class="text-green-600 hover:text-green-900 p-1 rounded hover:bg-green-50" 
                                        title="View Projects">
                                    <i class="fas fa-tasks"></i>
                                </button>
                                <button wire:click="sendMessage({{ $member->id }})" 
                                        class="text-purple-600 hover:text-purple-900 p-1 rounded hover:bg-purple-50" 
                                        title="Send Message">
                                    <i class="fas fa-envelope"></i>
                                </button>
                                <div class="relative">
                                    <button wire:click="toggleMemberActions({{ $member->id }})" 
                                            class="text-gray-400 hover:text-gray-600 p-1 rounded hover:bg-gray-50">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    @if(isset($showMemberActions[$member->id]))
                                    <div class="absolute right-0 top-full mt-1 w-48 bg-white rounded-md shadow-lg z-50 border">
                                        <div class="py-1">
                                            <button wire:click="assignToProject({{ $member->id }})" 
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-plus-circle mr-2"></i> Assign to Project
                                            </button>
                                            <button wire:click="changeRole({{ $member->id }})" 
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-user-cog mr-2"></i> Change Role
                                            </button>
                                            <div class="border-t border-gray-100">
                                                <button wire:click="removeMember({{ $member->id }})" 
                                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                    <i class="fas fa-user-times mr-2"></i> Remove from Hub
                                                </button>
                                            </div>
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
                                <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                                <p class="text-lg font-medium text-gray-900 mb-2">No members found</p>
                                <p class="text-sm text-gray-500">This hub doesn't have any members with projects yet.</p>
                                <button wire:click="showAddMemberModal" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                                    Add First Member
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($hubMembers->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $hubMembers->links() }}
        </div>
        @endif
    </div>

    <!-- Member Details Modal -->
    @if($showMemberModal && $selectedMember)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeMemberModal">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-3xl w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900">Member Details - {{ $selectedMember->name }}</h3>
                <button wire:click="closeMemberModal" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Member Info -->
                <div class="lg:col-span-1">
                    <div class="text-center mb-6">
                        <img class="h-24 w-24 rounded-full object-cover mx-auto mb-4" 
                             src="{{ $selectedMember->profile_photo_path ? asset('storage/' . $selectedMember->profile_photo_path) : asset('images/default-avatar.png') }}" 
                             alt="{{ $selectedMember->name }}">
                        <h4 class="text-lg font-medium text-gray-900">{{ $selectedMember->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $selectedMember->email }}</p>
                    </div>
                    
                    <div class="space-y-3">
                        @if($selectedMember->regno)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Registration Number</label>
                            <p class="text-sm text-gray-900">{{ $selectedMember->regno }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Member Since</label>
                            <p class="text-sm text-gray-900">{{ $selectedMember->created_at ?->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Projects</label>
                            <p class="text-sm text-gray-900">{{ $selectedMember->projects_count ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Projects List -->
                <div class="lg:col-span-2">
                    <h5 class="text-lg font-medium text-gray-900 mb-4">Projects in this Hub</h5>
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        @forelse($selectedMember->hub_projects ?? [] as $project)
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
                                    </div>
                                </div>
                                <a   href="{{ route('individual.project.list',  $project->id) }}"
                                        class="text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="fas fa-external-link-alt"></i>
</a>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 text-center py-4">No projects in this hub</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-6 pt-6 border-t border-gray-200">
                <button wire:click="closeMemberModal" 
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
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
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
</div>

</div>
