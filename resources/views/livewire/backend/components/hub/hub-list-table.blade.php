<div>
    <!-- Filters -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="col-span-1">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input wire:model.debounce.300ms="search" type="text" placeholder="Search for hubs" 
                    class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        <div class="col-span-1">
            <div class="relative">
                <select wire:model="supervisorFilter" class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                <select wire:model="statusFilter" class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- User table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
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
                    <th wire:click="sortBy('supervisor_id')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                        Supervisor
                        @if($sortField === 'supervisor_id')
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
                    <th wire:click="sortBy('phone_number')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                        Phone
                        @if($sortField === 'phone_number')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                        @else
                            <i class="fas fa-sort text-gray-400 ml-1"></i>
                        @endif
                    </th>
                    <th wire:click="sortBy('address')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                        Address
                        @if($sortField === 'address')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                        @else
                            <i class="fas fa-sort text-gray-400 ml-1"></i>
                        @endif
                    </th>
                    <th wire:click="sortBy('status')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
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
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0">
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset($hub->image) }}" alt="{{ $hub->name }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $hub->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($hub->supervisor)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $hub->supervisor->name }}
                            </span>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $hub->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $hub->phone_number }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500 truncate max-w-xs">{{ $hub->address }}</div>
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
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium relative">
                        <button type="button" wire:click="toggleActions({{ $hub->id }})" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        
                        @if(isset($showActions[$hub->id]))
                        <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                           
                        <div class="py-1 relative space-y-1">
                            <!-- Delete Button -->
                            <button 
                                type="button"
                                wire:click="confirmDelete({{ $hub->id }})" 
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 flex items-center"
                            >
                                <i class="fas fa-trash mr-2"></i> Delete
                            </button>

                            <!-- Edit Button -->
                            <button 
                                type="button"
                                wire:click="editHub({{ $hub->id }})" 
                                class="w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-gray-100 flex items-center"
                            >
                                <i class="fas fa-edit mr-2"></i> Edit
                            </button>
                        </div>




                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach

                @if($hubs->count() == 0)
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        No hubs found. Please adjust your search criteria.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $hubs->links() }}
    </div>

    <!-- Delete Confirmation Modal - Using native JavaScript for compatibility -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Listen for Livewire event
            window.addEventListener('show-delete-modal', function(event) {
                var hubId = event.detail.hubId;
                
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
                modalMessage.textContent = 'Are you sure you want to delete this hub? This action cannot be undone.';
                
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
                    // Call Livewire method to delete the hub
                    Livewire.dispatch('deleteHub', { id: hubId });
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
        }, 3000);
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
        }, 3000);
    </script>
    @endif
</div>