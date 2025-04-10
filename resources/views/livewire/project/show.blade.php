<!-- resources/views/livewire/project/show.blade.php -->
<div>
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <h3 class="text-2xl leading-6 font-medium text-gray-900">{{ $project->title }}</h3>
            <div class="mt-3 sm:mt-0 sm:ml-4">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    @if($project->status == 'draft') bg-gray-100 text-gray-800 
                    @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800 
                    @elseif($project->status == 'completed') bg-green-100 text-green-800 
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                </span>
            </div>
        </div>
        
        <!-- Success Message -->
        @if (session()->has('message'))
            <div class="rounded-md bg-green-50 p-4 mt-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Project Details -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-5">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Project Details</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Created on {{ $project->created_at->format('M d, Y') }}</p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $project->description }}</dd>
                    </div>
                    
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Hub</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $project->hub ? $project->hub->name : 'Not assigned' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
        
        <!-- Supervisor Section -->
        <div class="bg-white shadow sm:rounded-lg mt-5">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Project Supervisor</h3>
                @if(auth()->user()->role && (auth()->user()->role->name == 'Admin' || auth()->user()->id == $project->creator()->first()?->id))
                    <button wire:click="toggleSupervisorForm" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ $supervisor ? 'Change' : 'Assign' }} Supervisor
                    </button>
                @endif
            </div>
            
            @if ($showSupervisorForm)
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <form wire:submit.prevent="assignSupervisor">
                        <div class="mb-4">
                            <label for="supervisorId" class="block text-sm font-medium text-gray-700">Select Supervisor</label>
                            <select id="supervisorId" wire:model="supervisorId" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">-- Select a supervisor --</option>
                                @foreach($availableUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('supervisorId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="flex justify-end space-x-3">
                            <button type="button" wire:click="toggleSupervisorForm" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Assign
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    @if ($supervisor)
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <span class="text-indigo-800 font-semibold">{{ substr($supervisor->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $supervisor->name }}</div>
                                <div class="text-sm text-gray-500">{{ $supervisor->email }}</div>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No supervisor assigned yet.</p>
                    @endif
                </div>
            @endif
        </div>
        
        <!-- Team Members Section -->
        <div class="bg-white shadow sm:rounded-lg mt-5">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Team Members</h3>
                @if($supervisor && (auth()->user()->id == $supervisor->id || auth()->user()->role && auth()->user()->role->name == 'Admin'))
                    <button wire:click="toggleMembersForm" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Manage Members
                    </button>
                @endif
            </div>
            
            @if ($showMembersForm)
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <form wire:submit.prevent="assignMembers">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Select Members</label>
                            <div class="mt-2 grid grid-cols-1 gap-2 sm:grid-cols-2 md:grid-cols-3">
                                @foreach($allUsers as $user)
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="member-{{ $user->id }}" type="checkbox" wire:model="selectedMembers" value="{{ $user->id }}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="member-{{ $user->id }}" class="font-medium text-gray-700">{{ $user->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('selectedMembers') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-4">
                            <button type="button" wire:click="toggleMembersForm" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Members
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="border-t border-gray-200">
                    @if ($members->count() > 0)
                        <ul class="divide-y divide-gray-200">
                            @foreach ($members as $member)
                                <li class="px-4 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                <span class="text-indigo-800 font-semibold">{{ substr($member->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $member->email }}</div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="px-4 py-5 sm:px-6">
                            <p class="text-sm text-gray-500">No team members assigned yet.</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
        
        <!-- Project Phases & Stages Section -->
        <div class="bg-white shadow sm:rounded-lg mt-5">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Project Phases</h3>
                @if($supervisor && auth()->user()->id == $supervisor->id)
                    @livewire('project.phase.create', ['project' => $project])
                @endif
            </div>
            
            <div class="border-t border-gray-200">
                @if ($phases->count() > 0)
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @foreach ($phases as $phase)
                                <li>
                                    <div class="relative pb-8">
                                        @if (!$loop->last)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center ring-8 ring-white">
                                                    <span class="text-white font-semibold">{{ $loop->iteration }}</span>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-lg font-medium text-gray-900">{{ $phase->name }}</p>
                                                    @if ($phase->description)
                                                        <p class="text-sm text-gray-500">{{ $phase->description }}</p>
                                                    @endif
                                                    
                                                    <!-- Stages -->
                                                    <div class="mt-4">
                                                        @if ($phase->stages->count() > 0)
                                                            <h4 class="text-sm font-medium text-gray-500 mb-2">Stages</h4>
                                                            <ul class="space-y-2">
                                                                @foreach ($phase->stages as $stage)
                                                                    <li class="bg-gray-50 rounded-md p-3">
                                                                        <div class="flex justify-between">
                                                                            <div>
                                                                                <a href="{{ route('stages.show', $stage->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                                                                    {{ $stage->name }}
                                                                                </a>
                                                                                @if ($stage->description)
                                                                                    <p class="text-xs text-gray-500 mt-1">{{ $stage->description }}</p>
                                                                                @endif
                                                                            </div>
                                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                                @if($stage->status == 'pending') bg-gray-100 text-gray-800 
                                                                                @elseif($stage->status == 'in_progress') bg-yellow-100 text-yellow-800 
                                                                                @elseif($stage->status == 'submitted') bg-blue-100 text-blue-800 
                                                                                @elseif($stage->status == 'returned') bg-red-100 text-red-800 
                                                                                @elseif($stage->status == 'approved') bg-green-100 text-green-800 
                                                                                @endif">
                                                                                {{ ucfirst(str_replace('_', ' ', $stage->status)) }}
                                                                            </span>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                        
                                                        @if($supervisor && auth()->user()->id == $supervisor->id)
                                                            <div class="mt-3">
                                                                @livewire('project.stage.create', ['phase' => $phase])
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="px-4 py-5 sm:px-6">
                        <p class="text-sm text-gray-500">No phases defined yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>