<div>
<div class="flex flex-col lg:flex-row">
    <!-- Main content (staff list) -->
    <div class="w-full {{ $showForm ? 'lg:w-2/3' : 'lg:w-full' }} transition-all duration-300">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Staff Management</h2>
                <button 
                    wire:click="createStaff"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center"
                >
                    <i class="fas fa-plus mr-2"></i> Add New Staff
                </button>
            </div>

            <!-- Filters -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="col-span-1">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        <input 
                            wire:model.debounce.300ms="search" 
                            type="text" 
                            placeholder="Search by name, email or reg number" 
                            class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="relative">
                        <select 
                            wire:model="roleFilter" 
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="relative">
                        <select 
                            wire:model="levelFilter" 
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">All Levels</option>
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Staff Table -->
            <div class="overflow-x-auto bg-white rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('name')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Name
                                @if($sortField === 'name')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort text-gray-400 ml-1"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('email')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Email
                                @if($sortField === 'email')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort text-gray-400 ml-1"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('regno')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Reg Number
                                @if($sortField === 'regno')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort text-gray-400 ml-1"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('role_id')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Role
                                @if($sortField === 'role_id')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort text-gray-400 ml-1"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('level_id')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Level
                                @if($sortField === 'level_id')
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
                        @foreach ($staff as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center">
                                        <span class="text-gray-600 font-medium text-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $user->regno ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->role)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $user->role->name }}
                                    </span>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->level)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $user->level->name }}
                                    </span>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium relative">
                                <button type="button" wire:click="toggleActions({{ $user->id }})" class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                
                                @if(isset($showActions[$user->id]))
                                <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                                    <div class="py-1">
                                        <button 
                                            type="button"
                                            wire:click="editStaff({{ $user->id }})" 
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        >
                                            <i class="fas fa-edit mr-2"></i> Edit
                                        </button>
                                        <button 
                                            type="button"
                                            wire:click="confirmDelete({{ $user->id }})" 
                                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
                                        >
                                            <i class="fas fa-trash mr-2"></i> Delete
                                        </button>
                                    </div>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                        @if($staff->count() == 0)
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No staff found. Please adjust your search criteria or add a new staff member.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $staff->links() }}
            </div>
        </div>
    </div>

    <!-- Side form (create/edit) -->
    @if($showForm)
    <div class="w-full lg:w-1/3 transition-all duration-300 mt-6 lg:mt-0 lg:pl-6">
        <div class="bg-white rounded-lg shadow p-6 sticky top-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800">
                    {{ $formMode === 'create' ? 'Add New Staff' : 'Edit Staff' }}
                </h3>
                <button wire:click="closeForm" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form wire:submit.prevent="saveStaff" class="space-y-4">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        wire:model="name" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        wire:model="email" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Reg Number -->
                <div>
                    <label for="regno" class="block text-sm font-medium text-gray-700">Registration Number</label>
                    <input 
                        type="text" 
                        id="regno" 
                        wire:model="regno" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                    @error('regno') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role_id" class="block text-sm font-medium text-gray-700">Role</label>
                    <select 
                        id="role_id" 
                        wire:model="role_id" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Level -->
                <div>
                    <label for="level_id" class="block text-sm font-medium text-gray-700">Level</label>
                    <select 
                        id="level_id" 
                        wire:model="level_id" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                        <option value="">Select Level</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                    @error('level_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Password (for new staff only) -->
                @if($formMode === 'create')
                <div>
                    <label class="block text-sm font-medium text-gray-700">Generated Password</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input 
                            type="text" 
                            readonly 
                            value="{{ $generatedPassword }}" 
                            class="flex-1 block w-full border border-gray-300 rounded-l-md py-2 px-3 bg-gray-50 text-gray-500 sm:text-sm"
                        >
                        <button 
                            type="button"
                            wire:click="generatePassword"
                            class="inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 rounded-r-md bg-gray-50 text-gray-500 hover:bg-gray-100"
                        >
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">This password will be provided to the staff member.</p>
                </div>
                @endif

                <!-- Submit Button -->
                <div class="pt-4">
                    <button 
                        type="submit" 
                        class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        {{ $formMode === 'create' ? 'Create Staff' : 'Update Staff' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal - Using JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Listen for Livewire event
            window.addEventListener('show-delete-modal', function(event) {
                var userId = event.detail.userId;
                
                // Create the modal backdrop
                var backdrop = document.createElement('div');
                backdrop.id = 'delete-modal-backdrop';
                backdrop.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                
                // Create the modal content
                var modalContent = document.createElement('div');
                modalContent.className = 'bg-white rounded-lg shadow-lg p-6 max-w-md w-full';
                
                // Add modal header
                var modalHeader = document.createElement('h3');
                modalHeader.className = 'text-lg font-semibold mb-4';
                modalHeader.textContent = 'Confirm Deletion';
                
                // Add modal message
                var modalMessage = document.createElement('p');
                modalMessage.className = 'mb-6';
                modalMessage.textContent = 'Are you sure you want to delete this staff member? This action cannot be undone.';
                
                // Add modal buttons container
                var buttonContainer = document.createElement('div');
                buttonContainer.className = 'flex justify-end space-x-3';
                
                // Add cancel button
                var cancelButton = document.createElement('button');
                cancelButton.className = 'px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2';
                cancelButton.textContent = 'Cancel';
                cancelButton.onclick = function() {
                    document.body.removeChild(backdrop);
                };
                
                // Add delete button
                var deleteButton = document.createElement('button');
                deleteButton.className = 'px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2';
                deleteButton.innerHTML = '<i class="fas fa-trash mr-2"></i> Delete';
                deleteButton.onclick = function() {
                    // Call Livewire method to delete the staff
                    Livewire.dispatch('deleteStaff', { id: userId });
                    document.body.removeChild(backdrop);
                };
                
                // Append elements to each other
                buttonContainer.appendChild(cancelButton);
                buttonContainer.appendChild(deleteButton);
                
                modalContent.appendChild(modalHeader);
                modalContent.appendChild(modalMessage);
                modalContent.appendChild(buttonContainer);
                
                backdrop.appendChild(modalContent);
                document.body.appendChild(backdrop);
            });
        });
    </script>

    <!-- Flash Messages -->
    @if(session()->has('message'))
    <div id="success-notification" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-md z-50">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('message') }}</span>
        </div>
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('success-notification').style.display = 'none';
        }, 5000);
    </script>
    @endif

    @if(session()->has('error'))
    <div id="error-notification" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded shadow-md z-50">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('error-notification').style.display = 'none';
        }, 5000);
    </script>
    @endif
</div>

</div>
