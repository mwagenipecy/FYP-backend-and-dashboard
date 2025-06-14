{{-- resources/views/livewire/backend/staff/table-list.blade.php --}}
<div>
    <div class="flex flex-col lg:flex-row">
        <!-- Main content (user list) -->
        <div class="w-full {{ $showForm ? 'lg:w-2/3' : 'lg:w-full' }} transition-all duration-300">
            <div class="bg-white rounded-lg shadow p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">User Management</h2>
                    <button 
                        wire:click="createUser"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors"
                    >
                        <i class="fas fa-plus mr-2"></i> Add New User
                    </button>
                </div>

                <!-- Filters -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                    <!-- Search -->
                    <div class="col-span-1">
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            <input 
                                wire:model.live.debounce.300ms="search" 
                                type="text" 
                                placeholder="Search users..." 
                                class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>
                    </div>

                    <!-- User Type Filter -->
                    <div class="col-span-1">
                        <div class="relative">
                            <select 
                                wire:model.live="userTypeFilter" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">All User Types</option>
                                <option value="student">Students</option>
                                <option value="staff">Staff</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-span-1">
                        <div class="relative">
                            <select 
                                wire:model.live="statusFilter" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="disabled">Disabled</option>
                                <option value="blocked">Blocked</option>
                                <option value="pending">Pending</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                        </div>
                    </div>

                    <!-- Role Filter -->
                    <div class="col-span-1">
                        <div class="relative">
                            <select 
                                wire:model.live="roleFilter" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">All Roles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                        </div>
                    </div>

                    <!-- Level Filter -->
                    <div class="col-span-1">
                        <div class="relative">
                            <select 
                                wire:model.live="levelFilter" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">All Levels</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                        </div>
                    </div>
                </div>

                <!-- User Table -->
                <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <!-- Name Column -->
                                <th wire:click="sortBy('name')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center space-x-1">
                                        <span>Name</span>
                                        @if($sortField === 'name')
                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-blue-500"></i>
                                        @else
                                            <i class="fas fa-sort text-gray-400"></i>
                                        @endif
                                    </div>
                                </th>

                                <!-- Email Column -->
                                <th wire:click="sortBy('email')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center space-x-1">
                                        <span>Email</span>
                                        @if($sortField === 'email')
                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-blue-500"></i>
                                        @else
                                            <i class="fas fa-sort text-gray-400"></i>
                                        @endif
                                    </div>
                                </th>

                                <!-- User Type Column -->
                                <th wire:click="sortBy('userType')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center space-x-1">
                                        <span>User Type</span>
                                        @if($sortField === 'userType')
                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-blue-500"></i>
                                        @else
                                            <i class="fas fa-sort text-gray-400"></i>
                                        @endif
                                    </div>
                                </th>

                                <!-- Status Column -->
                                <th wire:click="sortBy('status')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center space-x-1">
                                        <span>Status</span>
                                        @if($sortField === 'status')
                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-blue-500"></i>
                                        @else
                                            <i class="fas fa-sort text-gray-400"></i>
                                        @endif
                                    </div>
                                </th>

                                <!-- Reg Number / Field Column -->
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reg Number / Field
                                </th>

                                <!-- Role Column -->
                                <th wire:click="sortBy('role_id')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center space-x-1">
                                        <span>Role</span>
                                        @if($sortField === 'role_id')
                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-blue-500"></i>
                                        @else
                                            <i class="fas fa-sort text-gray-400"></i>
                                        @endif
                                    </div>
                                </th>

                                <!-- Level Column -->
                                <th wire:click="sortBy('level_id')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center space-x-1">
                                        <span>Level</span>
                                        @if($sortField === 'level_id')
                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-blue-500"></i>
                                        @else
                                            <i class="fas fa-sort text-gray-400"></i>
                                        @endif
                                    </div>
                                </th>

                                <!-- Actions Column -->
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors {{ in_array($user->status, ['disabled', 'blocked']) ? 'bg-gray-50/50 opacity-75' : '' }}">
                                    <!-- Name -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12 relative">
                                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                                
                                                <!-- Status Indicator Badge -->
                                                @if($user->status === 'blocked')
                                                    <div class="absolute -top-1 -right-1 h-5 w-5 bg-red-500 rounded-full flex items-center justify-center border-2 border-white">
                                                        <i class="fas fa-ban text-white text-xs"></i>
                                                    </div>
                                                @elseif($user->status === 'disabled')
                                                    <div class="absolute -top-1 -right-1 h-5 w-5 bg-yellow-500 rounded-full flex items-center justify-center border-2 border-white">
                                                        <i class="fas fa-pause text-white text-xs"></i>
                                                    </div>
                                                @elseif($user->status === 'pending')
                                                    <div class="absolute -top-1 -right-1 h-5 w-5 bg-blue-500 rounded-full flex items-center justify-center border-2 border-white">
                                                        <i class="fas fa-clock text-white text-xs"></i>
                                                    </div>
                                                @elseif($user->status === 'active')
                                                    <div class="absolute -top-1 -right-1 h-5 w-5 bg-green-500 rounded-full flex items-center justify-center border-2 border-white">
                                                        <i class="fas fa-check text-white text-xs"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Email -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</div>
                                    </td>

                                    <!-- User Type -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->userType)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                {{ $user->userType === 'student' 
                                                    ? 'bg-purple-100 text-purple-800 border border-purple-200' 
                                                    : 'bg-orange-100 text-orange-800 border border-orange-200' }}">
                                                <i class="fas fa-{{ $user->userType === 'student' ? 'graduation-cap' : 'user-tie' }} mr-1"></i>
                                                {{ ucfirst($user->userType) }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                                <i class="fas fa-question mr-1"></i>
                                                Unknown
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusConfig = [
                                                'active' => ['bg-green-100', 'text-green-800', 'border-green-200', 'check-circle'],
                                                'inactive' => ['bg-gray-100', 'text-gray-800', 'border-gray-200', 'circle'],
                                                'disabled' => ['bg-yellow-100', 'text-yellow-800', 'border-yellow-200', 'pause-circle'],
                                                'blocked' => ['bg-red-100', 'text-red-800', 'border-red-200', 'ban'],
                                                'pending' => ['bg-blue-100', 'text-blue-800', 'border-blue-200', 'clock'],
                                            ];
                                            $config = $statusConfig[$user->status ?? 'inactive'] ?? $statusConfig['inactive'];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $config[0] }} {{ $config[1] }} border {{ $config[2] }}">
                                            <i class="fas fa-{{ $config[3] }} mr-1"></i>
                                            {{ ucfirst($user->status ?? 'inactive') }}
                                        </span>
                                    </td>

                                    <!-- Reg Number / Field -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            @if($user->userType === 'student')
                                                {{ $user->regno ?: 'N/A' }}
                                            @elseif($user->userType === 'staff')
                                                {{ $user->fieldType ?: 'N/A' }}
                                            @else
                                                {{ $user->regno ?: $user->fieldType ?: 'N/A' }}
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Role -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->role)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                <i class="fas fa-user-tag mr-1"></i>
                                                {{ $user->role->name }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 text-sm">No role assigned</span>
                                        @endif
                                    </td>

                                    <!-- Level -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->level)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                <i class="fas fa-layer-group mr-1"></i>
                                                {{ $user->level->name }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 text-sm">No level assigned</span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium relative">
                                        <button 
                                            type="button" 
                                            wire:click="toggleActions({{ $user->id }})" 
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-colors"
                                            title="More actions"
                                        >
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        
                                        @if(isset($showActions[$user->id]))
                                            <div class="absolute right-0 top-full mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 z-50 py-2" 
                                                 x-data 
                                                 x-on:click.outside="$wire.showActions = $wire.showActions.filter(id => id !== {{ $user->id }})">
                                                
                                                <!-- User Info Header -->
                                                <div class="px-4 py-2 border-b border-gray-100">
                                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                                </div>

                                                <!-- Edit Action -->
                                                <button 
                                                    type="button"
                                                    wire:click="editUser({{ $user->id }})" 
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center transition-colors"
                                                >
                                                    <i class="fas fa-edit text-blue-500 mr-3 w-4"></i> 
                                                    Edit User Details
                                                </button>

                                                <div class="border-t border-gray-100 my-1"></div>

                                                <!-- Status Management Actions -->
                                                <div class="px-4 py-1">
                                                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status Management</div>
                                                </div>

                                                @if($user->status === 'active')
                                                    <button 
                                                        type="button"
                                                        wire:click="disableUser({{ $user->id }})" 
                                                        class="w-full text-left px-4 py-2 text-sm text-yellow-700 hover:bg-yellow-50 flex items-center transition-colors"
                                                    >
                                                        <i class="fas fa-pause text-yellow-500 mr-3 w-4"></i> 
                                                        Disable User Access
                                                    </button>
                                                    <button 
                                                        type="button"
                                                        wire:click="blockUser({{ $user->id }})" 
                                                        class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50 flex items-center transition-colors"
                                                    >
                                                        <i class="fas fa-ban text-red-500 mr-3 w-4"></i> 
                                                        Block User Account
                                                    </button>
                                                @elseif($user->status === 'disabled')
                                                    <button 
                                                        type="button"
                                                        wire:click="enableUser({{ $user->id }})" 
                                                        class="w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-50 flex items-center transition-colors"
                                                    >
                                                        <i class="fas fa-play text-green-500 mr-3 w-4"></i> 
                                                        Enable User Access
                                                    </button>
                                                    <button 
                                                        type="button"
                                                        wire:click="blockUser({{ $user->id }})" 
                                                        class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50 flex items-center transition-colors"
                                                    >
                                                        <i class="fas fa-ban text-red-500 mr-3 w-4"></i> 
                                                        Block User Account
                                                    </button>
                                                @elseif($user->status === 'blocked')
                                                    <button 
                                                        type="button"
                                                        wire:click="unblockUser({{ $user->id }})" 
                                                        class="w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-50 flex items-center transition-colors"
                                                    >
                                                        <i class="fas fa-unlock text-green-500 mr-3 w-4"></i> 
                                                        Unblock User Account
                                                    </button>
                                                @else
                                                    <button 
                                                        type="button"
                                                        wire:click="activateUser({{ $user->id }})" 
                                                        class="w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-50 flex items-center transition-colors"
                                                    >
                                                        <i class="fas fa-check-circle text-green-500 mr-3 w-4"></i> 
                                                        Activate User Account
                                                    </button>
                                                @endif

                                                <div class="border-t border-gray-100 my-1"></div>

                                                <!-- Security Actions -->
                                                <div class="px-4 py-1">
                                                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Security</div>
                                                </div>

                                                <button 
                                                    type="button"
                                                    wire:click="resetPassword({{ $user->id }})" 
                                                    class="w-full text-left px-4 py-2 text-sm text-blue-700 hover:bg-blue-50 flex items-center transition-colors"
                                                >
                                                    <i class="fas fa-key text-blue-500 mr-3 w-4"></i> 
                                                    Reset Password
                                                </button>

                                                <div class="border-t border-gray-100 my-1"></div>

                                                <!-- Danger Zone -->
                                                <div class="px-4 py-1">
                                                    <div class="text-xs font-medium text-red-500 uppercase tracking-wider">Danger Zone</div>
                                                </div>

                                                <button 
                                                    type="button"
                                                    wire:click="confirmDelete({{ $user->id }})" 
                                                    class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50 flex items-center transition-colors"
                                                >
                                                    <i class="fas fa-trash text-red-500 mr-3 w-4"></i> 
                                                    Delete User Permanently
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                                            <p class="text-gray-500 mb-4">Try adjusting your search criteria or add a new user to get started.</p>
                                            <button 
                                                wire:click="createUser"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors"
                                            >
                                                <i class="fas fa-plus mr-2"></i> Add First User
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                        </div>
                        <div>
                            {{ $users->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Side Form Panel -->
        @if($showForm)
            <div class="w-full lg:w-1/3 transition-all duration-300 mt-6 lg:mt-0 lg:pl-6">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6">
                    <!-- Form Header -->
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ $formMode === 'create' ? 'Add New User' : 'Edit User' }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $formMode === 'create' ? 'Create a new user account' : 'Update user information' }}
                            </p>
                        </div>
                        <button 
                            wire:click="closeForm" 
                            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-colors"
                            title="Close form"
                        >
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Form -->
                    <form wire:submit.prevent="saveUser" class="space-y-6">
                        <!-- User Type -->
                        <div>
                            <label for="userType" class="block text-sm font-medium text-gray-700 mb-2">
                                User Type <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="userType" 
                                wire:model.live="userType" 
                                wire:change="handleUserTypeChange"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                            >
                                <option value="">Select User Type</option>
                                <option value="student">Student</option>
                                <option value="staff">Staff</option>
                            </select>
                            @error('userType') 
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                wire:model="name" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter full name"
                                required
                            >
                            @error('name') 
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                wire:model="email" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter email address"
                                required
                            >
                            @error('email') 
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Status (for edit mode) -->
                        @if($formMode === 'edit')
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Account Status <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="status" 
                                    wire:model="status" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                                    <option value="active">Active - Full access</option>
                                    <option value="inactive">Inactive - Limited access</option>
                                    <option value="disabled">Disabled - No access</option>
                                    <option value="blocked">Blocked - Security restriction</option>
                                    <option value="pending">Pending - Awaiting activation</option>
                                </select>
                                @error('status') 
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        @endif

                        <!-- Registration Number (for students only) -->
                        @if($userType === 'student')
                            <div>
                                <label for="regno" class="block text-sm font-medium text-gray-700 mb-2">
                                    Registration Number
                                </label>
                                <input 
                                    type="text" 
                                    id="regno" 
                                    wire:model="regno" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="e.g., REG2024001"
                                >
                                @error('regno') 
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-2 text-sm text-gray-500">Optional: Leave blank if not available</p>
                            </div>
                        @endif

                        <!-- Field Type (for staff only) -->
                        @if($userType === 'staff')
                            <div>
                                <label for="fieldType" class="block text-sm font-medium text-gray-700 mb-2">
                                    Field of Expertise <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="fieldType" 
                                    wire:model="fieldType" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required
                                >
                                    <option value="">Select Field of Expertise</option>
                                    <option value="Technology">Technology</option>
                                    <option value="Education">Education</option>
                                    <option value="Health">Health & Medicine</option>
                                    <option value="IoT">Internet of Things (IoT)</option>
                                    <option value="Engineering">Engineering</option>
                                    <option value="Business">Business & Management</option>
                                    <option value="Science">Science & Research</option>
                                    <option value="Arts">Arts & Humanities</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('fieldType') 
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        @endif

                        <!-- Role -->
                        <div>
                            <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">
                                User Role <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="role_id" 
                                wire:model="role_id" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                            >
                                <option value="">Select User Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role_id') 
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Level -->
                        <div>
                            <label for="level_id" class="block text-sm font-medium text-gray-700 mb-2">
                                User Level <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="level_id" 
                                wire:model="level_id" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                            >
                                <option value="">Select User Level</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                @endforeach
                            </select>
                            @error('level_id') 
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password (for new users only) -->
                        @if($formMode === 'create')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Generated Password
                                </label>
                                <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                                    <input 
                                        type="text" 
                                        readonly 
                                        value="{{ $generatedPassword }}" 
                                        class="flex-1 px-4 py-2 bg-gray-50 text-gray-700 font-mono text-sm"
                                    >
                                    <button 
                                        type="button"
                                        wire:click="generatePassword"
                                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 border-l border-gray-300 transition-colors"
                                        title="Generate new password"
                                    >
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    This password will be provided to the user. Make sure to share it securely.
                                </p>
                            </div>
                        @endif

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <button 
                                type="button"
                                wire:click="closeForm" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit" 
                                class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors flex items-center"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-50 cursor-not-allowed"
                            >
                                <span wire:loading.remove>
                                    <i class="fas fa-{{ $formMode === 'create' ? 'plus' : 'save' }} mr-2"></i>
                                    {{ $formMode === 'create' ? 'Create User' : 'Update User' }}
                                </span>
                                <span wire:loading>
                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                    {{ $formMode === 'create' ? 'Creating...' : 'Updating...' }}
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <!-- Status Change Confirmation Modal -->
    @if($showStatusModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $statusModalTitle }}</h3>
                </div>
                
                <div class="px-6 py-4">
                    <p class="text-gray-600 leading-relaxed">{{ $statusModalMessage }}</p>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button 
                        wire:click="cancelStatusChange"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors"
                    >
                        Cancel
                    </button>
                    <button 
                        wire:click="confirmStatusChange"
                        class="px-4 py-2 text-sm font-medium text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors {{ $statusModalButtonClass }} hover:opacity-90"
                    >
                        {{ $statusModalButtonText }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    <div 
        x-data="{ showDeleteModal: false, userId: null }"
        x-on:show-delete-modal.window="showDeleteModal = true; userId = $event.detail.userId"
    >
        <div x-show="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" x-transition>
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all" x-show="showDeleteModal" x-transition.scale>
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Confirm Deletion</h3>
                        </div>
                    </div>
                </div>
                
                <div class="px-6 py-4">
                    <p class="text-gray-600 leading-relaxed">
                        Are you sure you want to permanently delete this user? This action cannot be undone and will remove all associated data including:
                    </p>
                    <ul class="mt-3 text-sm text-gray-500 space-y-1">
                        <li class="flex items-center">
                            <i class="fas fa-check text-red-500 mr-2"></i>
                            User profile and account information
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-red-500 mr-2"></i>
                            Associated activity logs
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-red-500 mr-2"></i>
                            All user-generated content
                        </li>
                    </ul>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button 
                        x-on:click="showDeleteModal = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors"
                    >
                        Cancel
                    </button>
                    <button 
                        x-on:click="$wire.deleteUser(userId); showDeleteModal = false"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors flex items-center"
                    >
                        <i class="fas fa-trash mr-2"></i>
                        Delete Permanently
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div class="fixed bottom-4 right-4 z-50 space-y-3">
        @if(session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-transition:enter="transform ease-out duration-300 transition" x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 5000)" class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-gray-900">Success!</p>
                            <p class="mt-1 text-sm text-gray-500">{{ session('message') }}</p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button x-on:click="show = false" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session()->has('error'))
            <div x-data="{ show: true }" x-show="show" x-transition:enter="transform ease-out duration-300 transition" x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 7000)" class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-gray-900">Error!</p>
                            <p class="mt-1 text-sm text-gray-500">{{ session('error') }}</p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button x-on:click="show = false" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session()->has('warning'))
            <div x-data="{ show: true }" x-show="show" x-transition:enter="transform ease-out duration-300 transition" x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 6000)" class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-gray-900">Warning!</p>
                            <p class="mt-1 text-sm text-gray-500">{{ session('warning') }}</p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button x-on:click="show = false" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session()->has('info'))
            <div x-data="{ show: true }" x-show="show" x-transition:enter="transform ease-out duration-300 transition" x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 8000)" class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-gray-900">Information</p>
                            <p class="mt-1 text-sm text-gray-500">{{ session('info') }}</p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button x-on:click="show = false" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>




    {{-- Add these buttons to your existing action menu in the blade template --}}

{{-- In your user table actions menu, add these email options --}}
@if(isset($showActions[$user->id]))
    <div class="absolute right-0 top-full mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 z-50 py-2">
        
        {{-- User Info Header --}}
        <div class="px-4 py-2 border-b border-gray-100">
            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
            <div class="text-xs text-gray-500">{{ $user->email }}</div>
        </div>

        {{-- Edit Action --}}
        <button 
            type="button"
            wire:click="editUser({{ $user->id }})" 
            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center transition-colors"
        >
            <i class="fas fa-edit text-blue-500 mr-3 w-4"></i> 
            Edit User Details
        </button>

        <div class="border-t border-gray-100 my-1"></div>

        {{-- EMAIL NOTIFICATIONS SECTION --}}
        <div class="px-4 py-1">
            <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email Notifications</div>
        </div>

        {{-- Send Welcome Email --}}
        <button 
            type="button"
            wire:click="testWelcomeEmail({{ $user->id }})" 
            class="w-full text-left px-4 py-2 text-sm text-blue-700 hover:bg-blue-50 flex items-center transition-colors"
        >
            <i class="fas fa-envelope text-blue-500 mr-3 w-4"></i> 
            Send Welcome Email
        </button>

        {{-- Notify Profile Update --}}
        <button 
            type="button"
            wire:click="notifyProfileUpdate({{ $user->id }})" 
            class="w-full text-left px-4 py-2 text-sm text-purple-700 hover:bg-purple-50 flex items-center transition-colors"
        >
            <i class="fas fa-bell text-purple-500 mr-3 w-4"></i> 
            Send Update Notification
        </button>

        <div class="border-t border-gray-100 my-1"></div>

        {{-- Status Management Actions --}}
        <div class="px-4 py-1">
            <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status Management</div>
        </div>

        @if($user->status === 'active')
            <button 
                type="button"
                wire:click="disableUser({{ $user->id }})" 
                class="w-full text-left px-4 py-2 text-sm text-yellow-700 hover:bg-yellow-50 flex items-center transition-colors"
            >
                <i class="fas fa-pause text-yellow-500 mr-3 w-4"></i> 
                Disable User Access
            </button>
            <button 
                type="button"
                wire:click="blockUser({{ $user->id }})" 
                class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50 flex items-center transition-colors"
            >
                <i class="fas fa-ban text-red-500 mr-3 w-4"></i> 
                Block User Account
            </button>
        @elseif($user->status === 'disabled')
            <button 
                type="button"
                wire:click="enableUser({{ $user->id }})" 
                class="w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-50 flex items-center transition-colors"
            >
                <i class="fas fa-play text-green-500 mr-3 w-4"></i> 
                Enable User Access
            </button>
            <button 
                type="button"
                wire:click="blockUser({{ $user->id }})" 
                class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50 flex items-center transition-colors"
            >
                <i class="fas fa-ban text-red-500 mr-3 w-4"></i> 
                Block User Account
            </button>
        @elseif($user->status === 'blocked')
            <button 
                type="button"
                wire:click="unblockUser({{ $user->id }})" 
                class="w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-50 flex items-center transition-colors"
            >
                <i class="fas fa-unlock text-green-500 mr-3 w-4"></i> 
                Unblock User Account
            </button>
        @else
            <button 
                type="button"
                wire:click="activateUser({{ $user->id }})" 
                class="w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-50 flex items-center transition-colors"
            >
                <i class="fas fa-check-circle text-green-500 mr-3 w-4"></i> 
                Activate User Account
            </button>
        @endif

        <div class="border-t border-gray-100 my-1"></div>

        {{-- Security Actions --}}
        <div class="px-4 py-1">
            <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Security</div>
        </div>

        <button 
            type="button"
            wire:click="resetPassword({{ $user->id }})" 
            class="w-full text-left px-4 py-2 text-sm text-blue-700 hover:bg-blue-50 flex items-center transition-colors"
        >
            <i class="fas fa-key text-blue-500 mr-3 w-4"></i> 
            Reset Password
        </button>

        <div class="border-t border-gray-100 my-1"></div>

        {{-- Danger Zone --}}
        <div class="px-4 py-1">
            <div class="text-xs font-medium text-red-500 uppercase tracking-wider">Danger Zone</div>
        </div>

        <button 
            type="button"
            wire:click="confirmDelete({{ $user->id }})" 
            class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50 flex items-center transition-colors"
        >
            <i class="fas fa-trash text-red-500 mr-3 w-4"></i> 
            Delete User Permanently
        </button>
    </div>
@endif




</div>

