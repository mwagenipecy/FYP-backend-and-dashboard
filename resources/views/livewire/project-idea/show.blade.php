<div>
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <h3 class="text-2xl leading-6 font-medium text-gray-900">{{ $projectIdea->title }}</h3>
            <div class="mt-3 sm:mt-0 sm:ml-4">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    @if($projectIdea->status == 'submitted') bg-blue-100 text-blue-800 
                    @elseif($projectIdea->status == 'under_review') bg-yellow-100 text-yellow-800 
                    @elseif($projectIdea->status == 'needs_qualification') bg-purple-100 text-purple-800 
                    @elseif($projectIdea->status == 'approved') bg-green-100 text-green-800 
                    @elseif($projectIdea->status == 'rejected') bg-red-100 text-red-800 
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $projectIdea->status)) }}
                </span>
            </div>
        </div>
        
        <!-- Project Idea Details -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-5">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Project Idea Details</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Submitted by {{ $projectIdea->user->name }} on {{ $projectIdea->created_at->format('M d, Y') }}</p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $projectIdea->description }}</dd>
                    </div>
                </dl>
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
        
        <!-- Admin/Reviewer Actions -->
        @if(auth()->check() && auth()->user()->role && (auth()->user()->role->name == 'Admin' || auth()->user()->role->name == 'Reviewer'))
            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mt-5">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Reviewer Actions</h3>
                        <p class="mt-1 text-sm text-gray-500">Review this project idea and decide on next steps.</p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            @if($projectIdea->status != 'approved' && $projectIdea->status != 'rejected')
                                <div>
                                    <button wire:click="approveIdea" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Approve & Create Project
                                    </button>
                                </div>
                                
                                <div>
                                    <button wire:click="showFeedback" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Reject Idea
                                    </button>
                                </div>
                                
                                <div class="sm:col-span-2">
                                    <button wire:click="showQualification" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        Request More Information
                                    </button>
                                </div>
                            @else
                                <div class="sm:col-span-2">
                                    <p class="text-sm text-gray-500">This idea has already been {{ $projectIdea->status }}.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            @if($showFeedbackForm)
                <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mt-5">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Rejection Feedback</h3>
                            <p class="mt-1 text-sm text-gray-500">Provide feedback on why this idea is being rejected.</p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form wire:submit.prevent="rejectIdea">
                                <div class="mb-4">
                                    <label for="feedback" class="block text-sm font-medium text-gray-700">Feedback</label>
                                    <textarea id="feedback" wire:model="feedback" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Explain why this idea is being rejected"></textarea>
                                    @error('feedback') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="flex justify-end space-x-3">
                                    <button type="button" wire:click="$set('showFeedbackForm', false)" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Cancel
                                    </button>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Submit Rejection
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            
            @if($showQualificationForm)
                <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mt-5">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Request Qualification</h3>
                            <p class="mt-1 text-sm text-gray-500">Request additional information from the idea submitter.</p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form wire:submit.prevent="requestQualification">
                                <div class="mb-4">
                                    <label for="qualificationRequest" class="block text-sm font-medium text-gray-700">Qualification Request</label>
                                    <textarea id="qualificationRequest" wire:model="qualificationRequest" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Specify what additional information is needed"></textarea>
                                    @error('qualificationRequest') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="flex justify-end space-x-3">
                                    <button type="button" wire:click="$set('showQualificationForm', false)" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Cancel
                                    </button>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        Send Request
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>