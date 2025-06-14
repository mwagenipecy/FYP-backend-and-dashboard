<div class="mt-6">
    <!-- Header with Add Button -->
    <!-- <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Hub Management</h2>
        <button wire:click="showAddModal" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
            <i class="fas fa-plus mr-2"></i> Add New Hub
        </button>
    </div> -->

    <!-- Enhanced Filters with Export Options -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Filter & Search</h3>
            <div class="flex space-x-2">
                <button wire:click="exportData" class="bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 text-sm transition-colors">
                    <i class="fas fa-download mr-1"></i> Export
                </button>
                <button wire:click="generateReport" class="bg-purple-600 text-white px-3 py-2 rounded-lg hover:bg-purple-700 text-sm transition-colors">
                    <i class="fas fa-file-alt mr-1"></i> Report
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="col-span-1">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <input wire:model.live="search" type="text" placeholder="Search for hubs" 
                        class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="col-span-1">
                <div class="relative">
                    <select wire:model.live="supervisorFilter" class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Supervisors</option>
                        @foreach($supervisors as $supervisor)
                            <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <div class="col-span-1">
                <div class="relative">
                    <select wire:model.live="statusFilter" class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <div class="col-span-1">
                <div class="relative">
                    <select wire:model.live="performanceFilter" class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Performance</option>
                        <option value="top_performers">Top Performers</option>
                        <option value="needs_attention">Needs Attention</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Hub Table with Performance Metrics -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th wire:click="sortBy('name')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-50">
                        Hub Details
                        @if($sortField === 'name')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                        @else
                            <i class="fas fa-sort text-gray-400 ml-1"></i>
                        @endif
                    </th>
                    <th wire:click="sortBy('supervisor_id')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-50">
                        Supervisor
                        @if($sortField === 'supervisor_id')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                        @else
                            <i class="fas fa-sort text-gray-400 ml-1"></i>
                        @endif
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Performance Metrics
                    </th>
                    <th wire:click="sortBy('status')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-50">
                        Status
                        @if($sortField === 'status')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                        @else
                            <i class="fas fa-sort text-gray-400 ml-1"></i>
                        @endif
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($hubs as $hub)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-12 w-12 flex-shrink-0">
                                <img class="h-12 w-12 rounded-full object-cover" 
                                     src="{{ $hub->image ? asset('storage/' . $hub->image) : asset('images/default-hub.png') }}" 
                                     alt="{{ $hub->name }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $hub->name }}</div>
                                <div class="text-sm text-gray-500">{{ $hub->email }}</div>
                                <div class="text-xs text-gray-400">{{ $hub->phone_number }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($hub->supervisor)
                            <div class="flex items-center">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $hub->supervisor->name }}
                                </span>
                            </div>
                        @else
                            <span class="text-gray-500 text-sm">Not assigned</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex space-x-4 text-sm">
                            <div class="flex items-center">
                                <i class="fas fa-project-diagram text-purple-500 mr-1"></i>
                                <span class="font-medium">{{ $hub->projects_count ?? 0 }}</span>
                                <span class="text-gray-500 ml-1">Projects</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-lightbulb text-yellow-500 mr-1"></i>
                                <span class="font-medium">{{ $hub->ideas_count ?? 0 }}</span>
                                <span class="text-gray-500 ml-1">Ideas</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-file-alt text-green-500 mr-1"></i>
                                <span class="font-medium">{{ $hub->documents_count ?? 0 }}</span>
                                <span class="text-gray-500 ml-1">Docs</span>
                            </div>
                        </div>
                        @if(($hub->projects_count ?? 0) > 0)
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                    <span class="w-1.5 h-1.5 bg-green-600 rounded-full mr-1"></span>
                                    High Activity
                                </span>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($hub->status == 'active')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-circle text-xs mr-1"></i> Active
                            </span>
                        @elseif($hub->status == 'inactive')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                <i class="fas fa-circle text-xs mr-1"></i> Inactive
                            </span>
                        @endif
                        <div class="text-xs text-gray-500 mt-1">
                            Created {{ $hub->created_at->diffForHumans() }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium relative">
                        <button type="button" wire:click="toggleActions({{ $hub->id }})" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        
                        @if(isset($showActions[$hub->id]))
                        <div class="absolute right-0 top-full mt-2 w-56 bg-white rounded-md shadow-lg z-50 border">
                            <div class="py-1 relative space-y-1">
                                <!-- View Button -->
                                <button 
                                    type="button"
                                    wire:click="viewHub({{ $hub->id }})" 
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center transition-colors"
                                >
                                    <i class="fas fa-eye mr-2"></i> View Details
                                </button>

                                <!-- Analytics Button -->
                                <a 
                                    
                                   href="{{ route('hub.summary', $hub->id ) }}"
                                    class="w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-gray-100 flex items-center transition-colors"
                                >
                                    <i class="fas fa-chart-line mr-2"></i> View Analytics
                                </a>

                                <!-- Edit Button -->
                                <button 
                                    type="button"
                                    wire:click="editHub({{ $hub->id }})" 
                                    class="w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-gray-100 flex items-center transition-colors"
                                >
                                    <i class="fas fa-edit mr-2"></i> Edit Hub
                                </button>

                                <!-- Manage Projects -->
                                <button 
                                    type="button"
                                    wire:click="manageProjects({{ $hub->id }})" 
                                    class="w-full text-left px-4 py-2 text-sm text-purple-600 hover:bg-gray-100 flex items-center transition-colors"
                                >
                                    <i class="fas fa-tasks mr-2"></i> Manage Projects
                                </button>

                                <!-- Delete Button -->
                                <div class="border-t border-gray-100">
                                    <button 
                                        type="button"
                                        wire:click="confirmDelete({{ $hub->id }})" 
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 flex items-center transition-colors"
                                    >
                                        <i class="fas fa-trash mr-2"></i> Delete Hub
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach

                @if($hubs->count() == 0)
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center py-8">
                            <i class="fas fa-search text-gray-300 text-4xl mb-4"></i>
                            <p class="text-lg text-gray-500 mb-2">No hubs found</p>
                            <p class="text-sm text-gray-400">Please adjust your search criteria or add a new hub</p>
                        </div>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>


  

   

    <!-- Add/Edit Hub Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeModal">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-2xl w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900">
                    {{ $isEditing ? 'Edit Hub' : 'Add New Hub' }}
                </h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form wire:submit.prevent="saveHub" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Hub Name *</label>
                        <input wire:model="name" type="text" id="name" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input wire:model="email" type="email" id="email" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                        <input wire:model="phone_number" type="text" id="phone_number" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone_number') border-red-500 @enderror">
                        @error('phone_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Supervisor -->
                    <div>
                        <label for="supervisor_id" class="block text-sm font-medium text-gray-700 mb-2">Supervisor</label>
                        <select wire:model="supervisor_id" id="supervisor_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('supervisor_id') border-red-500 @enderror">
                            <option value="">Select Supervisor</option>
                            @foreach($supervisors as $supervisor)
                                <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                            @endforeach
                        </select>
                        @error('supervisor_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select wire:model="status" id="status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <textarea wire:model="address" id="address" rows="3" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-500 @enderror"></textarea>
                        @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Image Upload -->
                    <div class="md:col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Hub Image</label>
                        <input wire:model="image" type="file" id="image" accept="image/*" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror">
                        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        
                        @if($image)
                            <div class="mt-2">
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="h-20 w-20 object-cover rounded-lg">
                            </div>
                        @elseif($isEditing && $existingImage)
                            <div class="mt-2">
                                <img src="{{ asset($existingImage) }}" alt="Current image" class="h-20 w-20 object-cover rounded-lg">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <button type="button" wire:click="closeModal" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        {{ $isEditing ? 'Update Hub' : 'Create Hub' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- View Hub Modal -->
    @if($showViewModal && $selectedHub)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeViewModal">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-2xl w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900">Hub Details</h3>
                <button wire:click="closeViewModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="space-y-6">
                <!-- Hub Image and Basic Info -->
                <div class="flex items-center space-x-4">
                    <div class="h-16 w-16 flex-shrink-0">
                        <img class="h-16 w-16 rounded-full object-cover" src="{{ asset($selectedHub->image) }}" alt="{{ $selectedHub->name }}">
                    </div>
                    <div>
                        <h4 class="text-lg font-medium text-gray-900">{{ $selectedHub->name }}</h4>
                        <p class="text-sm text-gray-500">
                            Status: 
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $selectedHub->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($selectedHub->status) }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <p class="text-sm text-gray-900">{{ $selectedHub->email ?: 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <p class="text-sm text-gray-900">{{ $selectedHub->phone_number ?: 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Supervisor</label>
                        <p class="text-sm text-gray-900">
                            {{ $selectedHub->supervisor ? $selectedHub->supervisor->name : 'Not assigned' }}
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Created Date</label>
                        <p class="text-sm text-gray-900">{{ $selectedHub->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <p class="text-sm text-gray-900">{{ $selectedHub->address ?: 'Not provided' }}</p>
                </div>
            </div>

            <!-- Modal Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 mt-6">
                <button wire:click="editHub({{ $selectedHub->id }})" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Hub
                </button>
                <button wire:click="closeViewModal" 
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full">
            <div class="flex items-center mb-4">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
            </div>
            <div class="text-center">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Confirm Deletion</h3>
                <p class="text-sm text-gray-500 mb-6">
                    Are you sure you want to delete this hub? This action cannot be undone.
                </p>
                <div class="flex justify-center space-x-3">
                    <button wire:click="closeDeleteModal" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="deleteHub" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors flex items-center">
                        <i class="fas fa-trash mr-2"></i>
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Flash Messages -->
    @if(session()->has('message'))
    <div id="success-notification" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300">
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
    <div id="error-notification" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300">
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

    <!-- Loading Indicator -->
    <div wire:loading class="fixed inset-0 bg-black bg-opacity-25 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-4 flex items-center space-x-2">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
            <span class="text-gray-700">Loading...</span>
        </div>
    </div>
</div>