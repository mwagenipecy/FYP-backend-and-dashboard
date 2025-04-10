<div>
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <div>
                <h3 class="text-2xl leading-6 font-medium text-gray-900">{{ $stage->name }}</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Project: <a href="{{ route('projects.show', $stage->project_id) }}" class="text-indigo-600 hover:text-indigo-900">{{ $stage->project->title }}</a>
                    @if($stage->phase)
                        | Phase: {{ $stage->phase->name }}
                    @endif
                </p>
            </div>
            <div class="mt-3 sm:mt-0 sm:ml-4">
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
        
        <!-- Stage Description -->
        @if($stage->description)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-5">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Description</h3>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <p class="text-sm text-gray-500">{{ $stage->description }}</p>
                </div>
            </div>
        @endif
        
        <!-- Submission Section -->
        <div class="bg-white shadow sm:rounded-lg mt-5">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Stage Submission</h3>
                @if(!$isSupervisor && $stage->status != 'approved' && auth()->user()->id != 2)  
                <!-- $stage->project->supervisor?->id -->
                    <button wire:click="toggleSubmissionForm" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ $latestSubmission ? 'Update' : 'Submit' }} Work
                    </button>
                @endif
            </div>
            
            @if($showSubmissionForm)
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <form wire:submit.prevent="submitStage">
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Submission Content</label>
                            <textarea id="content" wire:model="content" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter your work for this stage"></textarea>
                            @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="flex justify-end space-x-3">
                            <button type="button" wire:click="toggleSubmissionForm" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            @elseif($latestSubmission)
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Latest Submission</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div class="prose max-w-none">
                                    {{ $latestSubmission->content }}
                                </div>
                                <div class="mt-2 text-xs text-gray-500">
                                    Submitted by {{ $latestSubmission->user->name }} on {{ $latestSubmission->created_at->format('M d, Y H:i') }}
                                </div>
                            </dd>
                        </div>
                        
                        @if($latestSubmission->feedback)
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Feedback</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div class="prose max-w-none">
                                        {{ $latestSubmission->feedback }}
                                    </div>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            @else
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <p class="text-sm text-gray-500">No submission yet.</p>
                </div>
            @endif
        </div>
        
        <!-- Supervisor Actions -->
        @if($isSupervisor && $latestSubmission && $stage->status == 'submitted')
            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mt-5">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Supervisor Actions</h3>
                        <p class="mt-1 text-sm text-gray-500">Review the submission and provide feedback if needed.</p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <button wire:click="approveStage" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Approve Submission
                                </button>
                            </div>
                            
                            <div>
                                <button wire:click="toggleFeedbackForm" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    Return with Feedback
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($showFeedbackForm)
                <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mt-5">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Return Feedback</h3>
                            <p class="mt-1 text-sm text-gray-500">Provide feedback on why this submission needs updates.</p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form wire:submit.prevent="returnStage">
                                <div class="mb-4">
                                    <label for="feedback" class="block text-sm font-medium text-gray-700">Feedback</label>
                                    <textarea id="feedback" wire:model="feedback" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Explain what needs to be improved"></textarea>
                                    @error('feedback') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="flex justify-end space-x-3">
                                    <button type="button" wire:click="$set('showFeedbackForm', false)" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Cancel
                                    </button>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        Return for Updates
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        
        <!-- Submission History -->
        @if($submissions->count() > 1)
            <div class="bg-white shadow sm:rounded-lg mt-5">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Submission History</h3>
                </div>
                <div class="border-t border-gray-200">
                    <ul class="divide-y divide-gray-200">
                        @foreach ($submissions as $index => $submission)
                            @if ($index > 0) <!-- Skip the latest submission as it's shown above -->
                                <li class="px-4 py-4">
                                    <div>
                                        <div class="flex justify-between">
                                            <p class="text-sm font-medium text-gray-900">Submitted by {{ $submission->user->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $submission->created_at->format('M d, Y H:i') }}</p>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-700">
                                            <p>{{ $submission->content }}</p>
                                        </div>
                                        @if($submission->feedback)
                                            <div class="mt-2 border-t border-gray-100 pt-2">
                                                <p class="text-sm font-medium text-gray-500">Feedback:</p>
                                                <p class="text-sm text-gray-700">{{ $submission->feedback }}</p>
                                            </div>
                                        @endif
                                        <div class="mt-2">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($submission->status == 'submitted') bg-blue-100 text-blue-800 
                                                @elseif($submission->status == 'returned') bg-red-100 text-red-800 
                                                @elseif($submission->status == 'approved') bg-green-100 text-green-800 
                                                @endif">
                                                {{ ucfirst($submission->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>

     