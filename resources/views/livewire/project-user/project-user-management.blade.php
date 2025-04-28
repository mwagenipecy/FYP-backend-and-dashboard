<div>
<div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Project Team Management</h2>
        
        @if(session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Management Tabs -->
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex" aria-label="Tabs">
                    <button 
                        wire:click="setActiveTab('members')" 
                        class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm {{ $activeTab === 'members' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                    >
                        Current Team
                    </button>
                    <button 
                        wire:click="setActiveTab('invitations')" 
                        class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm {{ $activeTab === 'invitations' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                    >
                        Pending Invitations 
                        @if(count($pendingInvitations) > 0)
                            <span class="ml-1 bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full text-xs">{{ count($pendingInvitations) }}</span>
                        @endif
                    </button>
                    <button 
                        wire:click="setActiveTab('add')" 
                        class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm {{ $activeTab === 'add' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                    >
                        Add Team Members
                    </button>
                </nav>
            </div>
        </div>
        
        <!-- Current Team Tab -->
        @if($activeTab === 'members')
            <div>
                <!-- Supervisor Section -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-lg font-medium">Project Supervisor</h3>
                        
                        @if($canManageProject)
                            <button 
                                wire:click="toggleSupervisorForm" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm py-1 px-3 rounded"
                            >
                                {{ $showSupervisorForm ? 'Cancel' : 'Change' }}
                            </button>
                        @endif
                    </div>
                    
                    @if($supervisor)
                        <div class="bg-gray-50 rounded p-4 flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                @if($supervisor->profile_photo_path)
                                    <img class="h-12 w-12 rounded-full object-cover" src="{{ Storage::url($supervisor->profile_photo_path) }}" alt="{{ $supervisor->name }}">
                                @else
                                    <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-indigo-800 font-semibold text-lg">{{ substr($supervisor->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-semibold">{{ $supervisor->name }}</h4>
                                <p class="text-gray-600 text-sm">{{ $supervisor->email }}</p>
                                <p class="text-gray-500 text-xs mt-1">Role: {{ $supervisor->role ? $supervisor->role->name : 'No Role Assigned' }}</p>
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-50 text-yellow-700 rounded p-4">
                            No supervisor has been assigned yet.
                            @if($canManageProject)
                                <button 
                                    wire:click="toggleSupervisorForm" 
                                    class="underline text-indigo-600 hover:text-indigo-800 ml-2"
                                >
                                    Assign a supervisor
                                </button>
                            @endif
                        </div>
                    @endif
                    
                    @if($showSupervisorForm)
                        <div class="mt-4 p-4 border rounded bg-gray-50">
                            <h4 class="font-semibold mb-3">Assign Supervisor</h4>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Select Supervisor</label>
                                <select 
                                    wire:model="supervisorId" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="">Select a user...</option>
                                    @foreach($availableUsers->filter(function($user) {
                                        return $user->role && ($user->role->name === 'Supervisor' || $user->role->name === 'Admin');
                                    }) as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                                @error('supervisorId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="flex justify-end">
                                @if($supervisor)
                                    <button 
                                        wire:click="removeSupervisor" 
                                        class="mr-2 bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded"
                                        onclick="return confirm('Are you sure you want to remove the current supervisor?')"
                                    >
                                        Remove Current
                                    </button>
                                @endif
                                
                                <button 
                                    wire:click="assignSupervisor" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded"
                                >
                                    Assign Supervisor
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Team Members Section -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-lg font-medium">Team Members</h3>
                        
                        @if($canManageProject)
                            <button 
                                wire:click="toggleMembersForm" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm py-1 px-3 rounded"
                            >
                                {{ $showMembersForm ? 'Cancel' : 'Manage Members' }}
                            </button>
                        @endif
                    </div>
                    
                    @if(count($members) > 0)
                        <div class="bg-gray-50 rounded p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($members as $member)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mr-3">
                                            @if($member->profile_photo_path)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($member->profile_photo_path) }}" alt="{{ $member->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                    <span class="text-indigo-800 font-semibold">{{ substr($member->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-sm">{{ $member->name }}</h4>
                                            <p class="text-gray-600 text-xs">{{ $member->email }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-50 text-yellow-700 rounded p-4">
                            No team members have been assigned yet.
                        </div>
                    @endif
                    
                    @if($showMembersForm)
                        <div class="mt-4 p-4 border rounded bg-gray-50">
                            <h4 class="font-semibold mb-3">Manage Team Members</h4>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Select Members</label>
                                
                                <div class="mb-2">
                                    <input 
                                        type="text" 
                                        wire:model.debounce.300ms="searchQuery" 
                                        placeholder="Search users..." 
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                    >
                                </div>
                                
                                <div class="border rounded max-h-60 overflow-y-auto">
                                    @if($availableUsers->isEmpty())
                                        <div class="p-3 text-gray-500 text-center">
                                            No users found.
                                        </div>
                                    @else
                                        @foreach($availableUsers as $user)
                                            <div class="p-2 hover:bg-gray-100 {{ $loop->even ? 'bg-gray-50' : '' }}">
                                                <label class="flex items-center cursor-pointer">
                                                    <input 
                                                        type="checkbox" 
                                                        wire:model="selectedMembers" 
                                                        value="{{ $user->id }}" 
                                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                    >
                                                    <span class="ml-2">
                                                        <span class="font-medium">{{ $user->name }}</span>
                                                        <span class="text-gray-600 text-sm ml-1">({{ $user->email }})</span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                @error('selectedMembers') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="flex justify-end">
                                <button 
                                    wire:click="assignMembers" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded"
                                >
                                    Update Team Members
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        
        <!-- Pending Invitations Tab -->
        @if($activeTab === 'invitations')
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Pending Invitations</h3>
                </div>
                
                @if(count($pendingInvitations) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recipient</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sent On</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expires</th>
                                    <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pendingInvitations as $invitation)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                @if($invitation->user_id)
                                                    {{ $invitation->user->name }}
                                                @else
                                                    <span class="italic">{{ $invitation->email }}</span>
                                                    <span class="text-xs text-gray-500">(New User)</span>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500">{{ $invitation->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $invitation->role === 'supervisor' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                                {{ ucfirst($invitation->role) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $invitation->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($invitation->isExpired())
                                                <span class="text-red-600">Expired</span>
                                            @else
                                                {{ $invitation->expires_at->format('M d, Y') }}
                                                <span class="text-xs text-gray-400">
                                                    ({{ $invitation->expires_at->diffForHumans() }})
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($canManageProject)
                                                <button 
                                                    wire:click="resendInvitation({{ $invitation->id }})" 
                                                    class="text-indigo-600 hover:text-indigo-900 mr-3"
                                                >
                                                    Resend
                                                </button>
                                                <button 
                                                    wire:click="cancelInvitation({{ $invitation->id }})" 
                                                    class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure you want to cancel this invitation?')"
                                                >
                                                    Cancel
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-gray-50 text-gray-500 p-4 rounded text-center">
                        No pending invitations found.
                    </div>
                @endif
            </div>
        @endif
        
        <!-- Add Team Members Tab -->
        @if($activeTab === 'add')
            <div>
                @if(!$canManageProject)
                    <div class="bg-yellow-50 text-yellow-700 p-4 rounded">
                        You do not have permission to add team members.
                    </div>
                @else
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-4">Invite New Team Members</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Invite Existing Users -->
                            <div class="bg-gray-50 p-4 rounded border">
                                <h4 class="font-semibold mb-3">Invite Existing Users</h4>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Search and Select Users</label>
                                    
                                    <input 
                                        type="text" 
                                        wire:model.debounce.300ms="searchQuery" 
                                        placeholder="Search by name or email" 
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mb-2"
                                    >
                                    
                                    <div class="border rounded max-h-60 overflow-y-auto mb-3">
                                        @if($availableUsers->isEmpty())
                                            <div class="p-3 text-gray-500 text-center">
                                                No users found.
                                            </div>
                                        @else
                                            @foreach($availableUsers as $user)
                                                <div class="p-2 hover:bg-gray-100 {{ $loop->even ? 'bg-gray-50' : '' }}">
                                                    <label class="flex items-center cursor-pointer">
                                                        <input 
                                                            type="checkbox" 
                                                            wire:model="selectedUsersToInvite" 
                                                            value="{{ $user->id }}" 
                                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                        >
                                                        <span class="ml-2">
                                                            <span class="font-medium">{{ $user->name }}</span>
                                                            <span class="text-gray-600 text-sm ml-1">({{ $user->email }})</span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    @error('selectedUsersToInvite') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                    <select 
                                        wire:model="invitationRole" 
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                    >
                                        <option value="member">Team Member</option>
                                        <option value="supervisor">Supervisor</option>
                                    </select>
                                    @error('invitationRole') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Message (Optional)</label>
                                    <textarea 
                                        wire:model="invitationMessage" 
                                        rows="3" 
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                        placeholder="Add a personal message to your invitation"
                                    ></textarea>
                                    @error('invitationMessage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="text-right">
                                    <button 
                                        wire:click="sendInvitationToExisting" 
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded"
                                    >
                                        Send Invitations
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Invite by Email -->
                            <div class="bg-gray-50 p-4 rounded border">
                                <h4 class="font-semibold mb-3">Invite by Email</h4>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input 
                                        type="email" 
                                        wire:model="invitationEmail" 
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                        placeholder="Enter email address"
                                    >
                                    @error('invitationEmail') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                    <select 
                                        wire:model="invitationRole" 
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                    >
                                        <option value="member">Team Member</option>
                                        <option value="supervisor">Supervisor</option>
                                    </select>
                                    @error('invitationRole') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Message (Optional)</label>
                                    <textarea 
                                        wire:model="invitationMessage" 
                                        rows="3" 
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                        placeholder="Add a personal message to your invitation"
                                    ></textarea>
                                    @error('invitationMessage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="text-right">
                                    <button 
                                        wire:click="sendInvitationToNew" 
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded"
                                    >
                                        Send Invitation
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

</div>
