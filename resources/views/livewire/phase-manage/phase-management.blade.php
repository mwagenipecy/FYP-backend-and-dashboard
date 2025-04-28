<div>
<div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <!-- Phase Tabs -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Project Phases</h3>
            
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
            
            <!-- Phase Navigation Tabs -->
            <div class="border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px">
                    @foreach($phases as $phase)
                        <li class="mr-2">
                            <button wire:click="setCurrentPhase({{ $phase['id'] }})" 
                                class="inline-block p-4 border-b-2 {{ $currentPhase && $currentPhase->id == $phase['id'] ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-600 hover:border-gray-300' }}">
                                {{ $phase['name'] }}
                                
                                @php
                                    $completedStages = 0;
                                    $totalStages = count($phase['stages']);
                                    foreach($phase['stages'] as $stage) {
                                        if($stage['status'] === 'approved') {
                                            $completedStages++;
                                        }
                                    }
                                    $progress = $totalStages > 0 ? ($completedStages / $totalStages) * 100 : 0;
                                @endphp
                                
                                <span class="ml-2 bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">
                                    {{ $completedStages }}/{{ $totalStages }}
                                </span>
                            </button>
                        </li>
                    @endforeach
                    
                    @if($userIsProjectSupervisor || auth()->user()->role->name === 'Admin')
                        <li class="mr-2">
                            <button wire:click="showAddPhase" class="inline-block p-4 text-gray-500 hover:text-gray-600">
                                <i class="fas fa-plus"></i> Add Phase
                            </button>
                        </li>
                    @endif
                </ul>
            </div>
            
            <!-- Add/Edit Phase Form -->
            @if($editingPhase !== null)
                <div class="mt-4 p-4 border rounded bg-gray-50">
                    <h4 class="font-semibold mb-2">{{ $editingPhase === 'new' ? 'Add New Phase' : 'Edit Phase' }}</h4>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Phase Name</label>
                        <input type="text" wire:model="phaseForm.name" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('phaseForm.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea wire:model="phaseForm.description" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        @error('phaseForm.description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Order</label>
                        <input type="number" wire:model="phaseForm.order" min="1"
                            class="mt-1 block w-1/4 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('phaseForm.order') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex justify-end">
                        <button wire:click="cancelPhaseEdit" class="mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                            Cancel
                        </button>
                        <button wire:click="savePhase" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                            Save Phase
                        </button>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Phase Content -->
        @if($currentPhase)
            <div class="bg-gray-50 p-4 mb-6 rounded">
                <h4 class="font-semibold mb-2">{{ $currentPhase->name }}</h4>
                <p class="text-gray-600">{{ $currentPhase->description }}</p>
                
                @if($userIsProjectSupervisor || auth()->user()->role->name === 'Admin')
                    <div class="mt-2">
                        <button wire:click="editPhase({{ $currentPhase->id }})" class="text-indigo-600 hover:text-indigo-800 mr-2">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button wire:click="deletePhase({{ $currentPhase->id }})" 
                                class="text-red-600 hover:text-red-800"
                                onclick="return confirm('Are you sure you want to delete this phase? This cannot be undone.')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                @endif
            </div>
            
            <!-- Stage Navigation -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold">Stages</h3>
                    
                    @if($userIsProjectSupervisor || auth()->user()->role->name === 'Admin')
                        <button wire:click="showAddStage({{ $currentPhase->id }})" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-1 px-3 rounded text-sm">
                            <i class="fas fa-plus"></i> Add Stage
                        </button>
                    @endif
                </div>
                
                <!-- Stage List -->
                <div class="border rounded">
                    @forelse($currentPhase->stages as $stage)
                        <div wire:click="setCurrentStage({{ $stage->id }})" 
                            class="p-3 border-b last:border-b-0 hover:bg-gray-50 cursor-pointer flex justify-between items-center {{ $currentStage && $currentStage->id == $stage->id ? 'bg-indigo-50' : '' }}">
                            <div>
                                <span class="font-medium">{{ $stage->name }}</span>
                                
                                @switch($stage->status)
                                    @case('approved')
                                        <span class="ml-2 bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Approved</span>
                                        @break
                                    @case('in_review')
                                        <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">In Review</span>
                                        @break
                                    @default
                                        <span class="ml-2 bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">Pending</span>
                                @endswitch
                            </div>
                            
                            @if($userIsProjectSupervisor || auth()->user()->role->name === 'Admin')
                                <div>
                                    <button wire:click.stop="editStage({{ $stage->id }})" class="text-indigo-600 hover:text-indigo-800 mr-2">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click.stop="deleteStage({{ $stage->id }})" 
                                            class="text-red-600 hover:text-red-800"
                                            onclick="return confirm('Are you sure you want to delete this stage? This cannot be undone.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-500">
                            No stages found for this phase. Add one to get started.
                        </div>
                    @endforelse
                </div>
                
                <!-- Add/Edit Stage Form -->
                @if($editingStage !== null)
                    <div class="mt-4 p-4 border rounded bg-gray-50">
                        <h4 class="font-semibold mb-2">{{ $editingStage === 'new' ? 'Add New Stage' : 'Edit Stage' }}</h4>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Stage Name</label>
                            <input type="text" wire:model="stageForm.name" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('stageForm.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea wire:model="stageForm.description" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            @error('stageForm.description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Order</label>
                            <input type="number" wire:model="stageForm.order" min="1"
                                class="mt-1 block w-1/4 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('stageForm.order') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="flex justify-end">
                            <button wire:click="cancelStageEdit" class="mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                                Cancel
                            </button>
                            <button wire:click="saveStage" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                                Save Stage
                            </button>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Current Stage Details -->
            @if($currentStage)
                <div class="border rounded p-4">
                    <h4 class="font-semibold text-lg mb-2">{{ $currentStage->name }}</h4>
                    <p class="text-gray-600 mb-4">{{ $currentStage->description }}</p>
                    
                    <!-- Stage Status -->
                    <div class="mb-4">
                        <span class="font-medium">Status: </span>
                        @switch($currentStage->status)
                            @case('approved')
                                <span class="bg-green-100 text-green-800 text-sm px-2 py-1 rounded">Approved</span>
                                @break
                            @case('in_review')
                                <span class="bg-yellow-100 text-yellow-800 text-sm px-2 py-1 rounded">In Review</span>
                                @break
                            @default
                                <span class="bg-gray-100 text-gray-800 text-sm px-2 py-1 rounded">Pending</span>
                        @endswitch
                    </div>
                    
                    <!-- Document Upload Section -->
                    <div class="mb-6">
                        <h5 class="font-semibold mb-2">Documents</h5>
                        
                        <div class="mb-4">
                            @forelse($documents as $document)
                                <div class="flex items-center justify-between p-3 border rounded mb-2 {{ $document->is_approved ? 'bg-green-50' : 'bg-gray-50' }}">
                                    <div>
                                        <span class="font-medium">{{ $document->title }}</span>
                                        <p class="text-sm text-gray-600">{{ $document->description }}</p>
                                        <div class="text-xs text-gray-500">
                                            Uploaded by: {{ \App\Models\User::find($document->uploaded_by)->name }} 
                                            on {{ $document->created_at->format('M d, Y') }}
                                            
                                            @if($document->is_approved)
                                                <span class="ml-2 bg-green-100 text-green-800 px-1 rounded">Approved</span>
                                            @else
                                                <span class="ml-2 bg-yellow-100 text-yellow-800 px-1 rounded">Pending Approval</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 mr-3">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                        
                                        @if(!$document->is_approved && $userIsProjectSupervisor)
                                            <button wire:click="approveDocument({{ $document->id }})" class="text-green-600 hover:text-green-800">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">No documents uploaded for this stage.</p>
                            @endforelse
                        </div>
                        
                        <!-- Document Upload Form -->
                        @if($currentStage->status !== 'approved')
                            <div class="p-4 border rounded bg-gray-50">
                                <h5 class="font-semibold mb-2">Upload New Document</h5>
                                
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Title</label>
                                    <input type="text" wire:model="documentTitle" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('documentTitle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea wire:model="documentDescription" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                    @error('documentDescription') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Document</label>
                                    <input type="file" wire:model="newDocument" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('newDocument') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="text-right">
                                    <button wire:click="uploadDocument" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                                        Upload Document
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Latest Submission -->
                    @if($latestSubmission)
                        <div class="mb-6">
                            <h5 class="font-semibold mb-2">Latest Submission</h5>
                            
                            <div class="p-4 border rounded">
                                <p class="mb-2">
                                    <span class="font-medium">Status:</span> 
                                    @switch($latestSubmission->status)
                                        @case('approved')
                                            <span class="bg-green-100 text-green-800 text-sm px-2 py-1 rounded">Approved</span>
                                            @break
                                        @case('rejected')
                                            <span class="bg-red-100 text-red-800 text-sm px-2 py-1 rounded">Rejected</span>
                                            @break
                                        @default
                                            <span class="bg-yellow-100 text-yellow-800 text-sm px-2 py-1 rounded">Submitted</span>
                                    @endswitch
                                </p>
                                
                                <p class="mb-2">
                                    <span class="font-medium">Submitted by:</span> 
                                    {{ \App\Models\User::find($latestSubmission->user_id)->name }}
                                </p>
                                
                                <p class="mb-2">
                                    <span class="font-medium">Submitted on:</span> 
                                    {{ $latestSubmission->created_at->format('M d, Y h:i A') }}
                                </p>
                                
                                <div class="mb-4">
                                    <p class="font-medium mb-1">Content:</p>
                                    <div class="p-3 bg-gray-50 rounded">
                                        {!! nl2br(e($latestSubmission->content)) !!}
                                    </div>
                                </div>
                                
                                @if($latestSubmission->feedback)
                                    <div class="mb-2">
                                        <p class="font-medium mb-1">Feedback:</p>
                                        <div class="p-3 bg-gray-50 rounded">
                                            {!! nl2br(e($latestSubmission->feedback)) !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    <!-- Submission Form (for members) -->
                    @if($userIsProjectMember && $currentStage->status !== 'approved')
                        <div class="mb-6">
                            <h5 class="font-semibold mb-2">Submit Work</h5>
                            
                            <div class="p-4 border rounded bg-gray-50">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Submission Content</label>
                                    <textarea wire:model="submission" rows="6"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                    @error('submission') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="text-right">
                                    <button wire:click="submitWork" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                                        Submit Work
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Feedback Form (for supervisors) -->
                    @if($userIsProjectSupervisor && $currentStage->status === 'in_review')
                        <div class="mb-6">
                            <h5 class="font-semibold mb-2">Provide Feedback</h5>
                            
                            <div class="p-4 border rounded bg-gray-50">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Feedback</label>
                                    <textarea wire:model="feedback" rows="6"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                    @error('feedback') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="flex justify-end">
                                    <button wire:click="provideFeedback('rejected')" class="mr-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">
                                        Reject
                                    </button>
                                    <button wire:click="provideFeedback('approved')" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                                        Approve
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center p-6 bg-gray-50 rounded">
                    <p class="text-gray-500">Select a stage to view details.</p>
                </div>
            @endif
        @else
            <div class="text-center p-6 bg-gray-50 rounded">
                <p class="text-gray-500">No phases found for this project. Add one to get started.</p>
            </div>
        @endif
    </div>
</div>
</div>
