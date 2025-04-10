
<div>


    <div class="container mx-auto px-4 py-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Member Onboarding</h1>
                <p class="mt-1 text-sm text-gray-600">Manage and track new member onboarding</p>
            </div>
            <div>
                <button 
                    onclick="window.location.href = ' '"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Back to Users
                </button>
            </div>
        </div>
        
        <!-- Flash Message -->
        @if(session()->has('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('message') }}</p>
            </div>
        @endif
        
        <!-- Onboarding Navigation -->
        <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Onboarding Options</h2>
            </div>
            
            <div class="p-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                <button 
                    wire:click="toggleInvitationSidebar"
                    class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-blue-400 focus:outline-none"
                >
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-lg font-medium text-gray-900">
                            Send Invitation
                        </p>
                        <p class="text-sm text-gray-500">
                            Email an invitation link to a new member
                        </p>
                    </div>
                </button>
                
                <button 
                    wire:click="toggleRegisterSidebar"
                    class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-blue-400 focus:outline-none"
                >
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-lg font-medium text-gray-900">
                            Register Member
                        </p>
                        <p class="text-sm text-gray-500">
                            Manually create a new member account
                        </p>
                    </div>
                </button>
                
                <button 
                    wire:click="toggleQuestionsSidebar"
                    class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-blue-400 focus:outline-none"
                >
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-lg font-medium text-gray-900">
                            Onboarding Questions
                        </p>
                        <p class="text-sm text-gray-500">
                            Manage questions for new members
                        </p>
                    </div>
                </button>
            </div>
        </div>
        
        <!-- Onboarding Statistics -->
        <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">Member Onboarding Statistics</h2>
                <div class="flex space-x-2">
                    <button 
                        wire:click="setStatsPeriod('month')" 
                        class="px-3 py-1 rounded-md {{ $statsPeriod === 'month' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}"
                    >
                        Month
                    </button>
                    <button 
                        wire:click="setStatsPeriod('quarter')" 
                        class="px-3 py-1 rounded-md {{ $statsPeriod === 'quarter' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}"
                    >
                        Quarter
                    </button>
                    <button 
                        wire:click="setStatsPeriod('year')" 
                        class="px-3 py-1 rounded-md {{ $statsPeriod === 'year' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}"
                    >
                        Year
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                <div class="h-80">
                    <!-- Line Chart -->
                    <canvas id="onboardingChart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Recent Invitations -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Recent Invitations</h2>
                </div>
                
                <div class="p-6">
                    <ul class="divide-y divide-gray-200">
                        @forelse($recentInvitations as $invitation)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $invitation->email }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Sent {{ $invitation->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $invitation->status === 'accepted' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($invitation->status) }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-center text-gray-500">
                                No recent invitations
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
            <!-- Pending Members -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Pending Members</h2>
                </div>
                
                <div class="p-6">
                    <ul class="divide-y divide-gray-200">
                        @forelse($pendingMembers as $member)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($member->profile_photo_path)
                                            <img class="h-10 w-10 rounded-full" src="{{ Storage::url($member->profile_photo_path) }}" alt="{{ $member->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-lg font-medium text-gray-600">{{ substr($member->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $member->name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Joined {{ $member->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div>
                                        <button 
                                            wire:click="$emit('approveMember', {{ $member->id }})"
                                            class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700"
                                        >
                                            Approve
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-center text-gray-500">
                                No pending members
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <!-- Invitation Sidebar -->
    <div 
        x-data="{ shown: @entangle('showRegisterSidebar') }"
        x-show="shown"
        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-0 overflow-hidden z-50"
        style="display: none;"
    >
        <div class="absolute inset-0 overflow-hidden">
            <div 
                x-show="shown"
                x-transition:enter="ease-in-out duration-500"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in-out duration-500"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                @click="shown = false"></div>
            
            <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                <div class="relative w-screen max-w-md">
                    <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                        <div class="px-4 py-6 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900">Register New Member</h2>
                                <div class="ml-3 h-7 flex items-center">
                                    <button
                                        @click="shown = false"
                                        class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    >
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sidebar content -->
                        <div class="mt-6 relative flex-1 px-4 sm:px-6">
                            <form wire:submit.prevent="registerMember">
                                <div class="space-y-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                        <div class="mt-1">
                                            <input 
                                                wire:model.defer="name"
                                                type="text" 
                                                id="name" 
                                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            >
                                        </div>
                                        @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                                        <div class="mt-1">
                                            <input 
                                                wire:model.defer="email"
                                                type="email" 
                                                id="email" 
                                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            >
                                        </div>
                                        @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="regno" class="block text-sm font-medium text-gray-700">Registration Number (Optional)</label>
                                        <div class="mt-1">
                                            <input 
                                                wire:model.defer="regno"
                                                type="text" 
                                                id="regno" 
                                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            >
                                        </div>
                                        @error('regno') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                        <div class="mt-1">
                                            <input 
                                                wire:model.defer="password"
                                                type="password" 
                                                id="password" 
                                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            >
                                        </div>
                                        @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                        <div class="mt-1">
                                            <input 
                                                wire:model.defer="password_confirmation"
                                                type="password" 
                                                id="password_confirmation" 
                                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            >
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="role_id" class="block text-sm font-medium text-gray-700">Role</label>
                                        <div class="mt-1">
                                            <select 
                                                wire:model.defer="role_id"
                                                id="role_id" 
                                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            >
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('role_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="level_id" class="block text-sm font-medium text-gray-700">Level</label>
                                        <div class="mt-1">
                                            <select 
                                                wire:model.defer="level_id"
                                                id="level_id" 
                                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            >
                                                @foreach($levels as $level)
                                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('level_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <button 
                                            type="submit"
                                            class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        >
                                            Register Member
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Onboarding Questions Sidebar -->
    <div 
        x-data="{ shown: @entangle('showQuestionsSidebar') }"
        x-show="shown"
        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-0 overflow-hidden z-50"
        style="display: none;"
    >
        <div class="absolute inset-0 overflow-hidden">
            <div 
                x-show="shown"
                x-transition:enter="ease-in-out duration-500"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in-out duration-500"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                @click="shown = false"
            ></div>
            
            <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                <div class="relative w-screen max-w-md">
                    <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                        <div class="px-4 py-6 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900">Onboarding Questions</h2>
                                <div class="ml-3 h-7 flex items-center">
                                    <button
                                        @click="shown = false"
                                        class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    >
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sidebar content -->
                        <div class="mt-6 relative flex-1 px-4 sm:px-6">
                            <div class="mb-6">
                                <h3 class="text-base font-medium text-gray-900 mb-4">Current Questions</h3>
                                
                                <ul class="divide-y divide-gray-200">
                                    @forelse($questions as $index => $question)
                                        <li class="py-4">
                                            <div class="flex items-start space-x-3">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $index + 1 }}. {{ $question['question'] }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $question['is_required'] ? 'Required' : 'Optional' }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <button 
                                                        wire:click="deleteQuestion({{ $question['id'] }})"
                                                        class="text-red-600 hover:text-red-800"
                                                    >
                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="py-4 text-center text-gray-500">
                                            No questions defined yet
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="text-base font-medium text-gray-900 mb-4">Add Question</h3>
                                
                                <form wire:submit.prevent="addQuestion">
                                    <div class="space-y-4">
                                        <div>
                                            <label for="newQuestion" class="block text-sm font-medium text-gray-700">Question Text</label>
                                            <div class="mt-1">
                                                <textarea 
                                                    wire:model.defer="newQuestion"
                                                    id="newQuestion" 
                                                    rows="3" 
                                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                                    placeholder="Enter your question here"
                                                ></textarea>
                                            </div>
                                            @error('newQuestion') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input
                                                    wire:model.defer="newQuestionRequired"
                                                    id="newQuestionRequired"
                                                    type="checkbox"
                                                    class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                                                >
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="newQuestionRequired" class="font-medium text-gray-700">Required Question</label>
                                                <p class="text-gray-500">Make this a required question for new members</p>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <button 
                                                type="submit"
                                                class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                            >
                                                Add Question
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Chart JS Initialization Script -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            let ctx = document.getElementById('onboardingChart').getContext('2d');
            
            // Sample data for initial rendering or fallback
            const sampleData = {
                month: {
                    labels: ['Day 1', 'Day 3', 'Day 7', 'Day 10', 'Day 15', 'Day 20', 'Day 25', 'Day 30'],
                    data: [3, 5, 8, 12, 7, 10, 15, 9]
                },
                quarter: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7', 'Week 8', 'Week 9', 'Week 10', 'Week 11', 'Week 12'],
                    data: [15, 22, 18, 25, 30, 28, 35, 32, 40, 45, 38, 42]
                },
                year: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    data: [45, 60, 75, 85, 95, 110, 130, 145, 160, 175, 190, 210]
                }
            };
            
            // Get current period from Livewire component or default to 'month'
            const currentPeriod = '{{ $statsPeriod }}' || 'month';
            
            let chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: sampleData[currentPeriod].labels,
                    datasets: [{
                        label: 'New Members',
                        data: sampleData[currentPeriod].data,
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                title: function(tooltipItems) {
                                    return tooltipItems[0].label;
                                },
                                label: function(context) {
                                    return `New members: ${context.parsed.y}`;
                                }
                            }
                        }
                    }
                }
            });
            
            // Update chart when stats change
            Livewire.on('statsUpdated', data => {
                if (data && data.length > 0) {
                    chart.data.labels = data.map(item => item.period);
                    chart.data.datasets[0].data = data.map(item => item.count);
                } else {
                    // Use sample data if no real data available
                    chart.data.labels = sampleData[currentPeriod].labels;
                    chart.data.datasets[0].data = sampleData[currentPeriod].data;
                }
                chart.update();
            });
            
            // Initial update with real data or fallback to sample data
            window.addEventListener('DOMContentLoaded', () => {
                try {
                    @this.getOnboardingStatsProperty().then(data => {
                        if (data && data.length > 0) {
                            chart.data.labels = data.map(item => item.period);
                            chart.data.datasets[0].data = data.map(item => item.count);
                            chart.update();
                        }
                    }).catch(error => {
                        console.log("Using sample data due to:", error);
                    });
                } catch (error) {
                    console.log("Using sample data due to:", error);
                }
            });
            
            // Listen for period changes
            Livewire.on('statsPeriodChanged', (newPeriod) => {
                const period = newPeriod || currentPeriod;
                
                try {
                    @this.getOnboardingStatsProperty().then(data => {
                        if (data && data.length > 0) {
                            chart.data.labels = data.map(item => item.period);
                            chart.data.datasets[0].data = data.map(item => item.count);
                        } else {
                            // Use sample data if no real data available
                            chart.data.labels = sampleData[period].labels;
                            chart.data.datasets[0].data = sampleData[period].data;
                        }
                        chart.update();
                    }).catch(error => {
                        // Use sample data on error
                        chart.data.labels = sampleData[period].labels;
                        chart.data.datasets[0].data = sampleData[period].data;
                        chart.update();
                        console.log("Using sample data due to:", error);
                    });
                } catch (error) {
                    // Use sample data on error
                    chart.data.labels = sampleData[period].labels;
                    chart.data.datasets[0].data = sampleData[period].data;
                    chart.update();
                    console.log("Using sample data due to:", error);
                }
            });
        });
    </script>
    @endpush



  


          <!-- Register Member Sidebar -->
    <div 
        x-data="{ shown: @entangle('showInvitationSidebar') }"
        x-show="shown"
        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-0 overflow-hidden z-50"
        style="display: none;"
    >
        <div class="absolute inset-0 overflow-hidden">
            <div 
                x-show="shown"
                x-transition:enter="ease-in-out duration-500"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in-out duration-500"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                @click="shown = false"></div>
            
            <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                <div class="relative w-screen max-w-md">
                    <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                        <div class="px-4 py-6 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900">Register New Member</h2>
                                <div class="ml-3 h-7 flex items-center">
                                    <button
                                        @click="shown = false"
                                        class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    >
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sidebar content -->
                        <div class="mt-6 relative flex-1 px-4 sm:px-6">
                            <form wire:submit.prevent="registerMember">
                                <div class="space-y-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                        <div class="mt-1">
                                            <input 
                                                wire:model.defer="name"
                                                type="text" 
                                                id="name" 
                                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            >
                                        </div>
                                        @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                                        <div class="mt-1">
                                            <input 
                                                wire:model.defer="email"
                                                type="email" 
                                                id="email" 
                                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            >
                                        </div>
                                        @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                        <div class="mt-1">
                                            <input 
                                                wire:model.defer="password"
                                                type="password" 
                                                id="password" 
                                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            >
                                        </div>
                                        @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                        <div class="mt-1">
                                            <input 
                                                wire:model.defer="password_confirmation"
                                                type="password" 
                                                id="password_confirmation" 
                                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            >
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <button 
                                            type="submit"
                                            class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        >
                                            Register Member
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

    

</div>

       


    
  
