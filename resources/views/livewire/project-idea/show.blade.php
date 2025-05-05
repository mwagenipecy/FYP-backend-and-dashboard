<div>
<x-breadcrumb :items="[
    ['label' => 'Idea Listing', 'url' => route('idea.list')],
  ['label' => 'View Idea', 'url' => route('idea.list')],

]" />

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


            <div>


            <!-- Button to toggle review status -->
            @if($projectIdea->status=='submitted')
                <button 
                    wire:click="toggleReviewStatus"
                    class="px-4 py-2 text-white font-medium rounded-md 
                        {{ $projectIdea->status  == 'under_review' ? 'bg-blue-600' : 'bg-amber-600' }} 
                        hover:bg-{{$projectIdea->status  == 'under_review' ? 'green' : 'yellow' }}-700 transition">
                    {{ $projectIdea->status  == 'under_review' ? 'Awaiting Approval' : 'Set Under Review' }}
                </button>
            @endif 

            </div>
        </div>
        
        <!-- Project Idea Details -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-5">
            <div class="px-4 py-5 sm:px-6">
                <div class="flex justify-between">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Project Idea Details</h3>


                @if($projectIdea->status=='rejected' || $projectIdea->status=='approved' )


                            @else

                <button  data-modal-target="createIdeaModal" data-modal-toggle="createIdeaModal"
           class="inline-flex items-center px-5 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Update Project Idea
            </button>

            @endif 



                </div>
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








        @forelse($feedBackList as $ideaFeedBack)
    <div class="bg-white shadow-sm border border-gray-200 mt-4 rounded-lg mb-6">
        <!-- Feedback Content -->
        <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Feedback</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $ideaFeedBack->comment }}</dd>

                    </div>
                </dl>
                @if($ideaFeedBack->link)
                <dl>
                    <div class="bg-gray-white px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500"></dt>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <div class="flex items-center space-x-2">
                            <input 
                                type="text" 
                                id="feedback-link" 
                                value="{{ $ideaFeedBack->link }}" 
                                readonly 
                                class="w-full text-sm text-gray-900 border rounded-md px-3 py-2 bg-gray-100 cursor-default focus:outline-none"
                            >
                            <button 
                                type="button" 
                                onclick="navigator.clipboard.writeText(document.getElementById('feedback-link').value)" 
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-indigo-600 rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Copy
                            </button>
                        </div>
                    </div>

                    </div>
                </dl>
                @endif 

               


            </div>


        <!-- Metadata -->
        <div class="px-6 py-3 bg-gray-50 flex justify-between items-center text-sm text-gray-600">
            <div>

            </div>
            <div>
            <div>
                Submitted by <span class="font-medium text-gray-800">{{ $ideaFeedBack->user->name }}</span>
            </div>
                {{ $ideaFeedBack->created_at->format('M d, Y h:i A') }}
            </div>
        </div>
    </div>


    @foreach ($replies as $repy)
    @if($repy->identifier== $ideaFeedBack->id )

    <div class="rounded-lg border border-1 border-blue-200 p-2 mt-2 bg-blue-100">  

        <div class="flex justify-end">
        <div class="text-gray-800">
            {{ $repy->comment }}

        </div>


        </div>

        <div class="flex justify-end text-xs" >
        <div>
        <span class="font-medium text-gray-800">{{ $repy->user->name }}</span>
        </div>
        {{ $repy->created_at->format('M d, Y h:i A') }}
        </div>
       
        </div>

        @endif 

@endforeach








<div class="space-y-2">
    <!-- Toggle Button -->

    @if($projectIdea->status=='rejected')

    @else
    <button wire:click="showFormFunction({{ $ideaFeedBack->id }})" class="text-sm text-indigo-600 hover:underline font-medium">
        {{ $ideaFeedBack->id ==$showForm ? 'Cancel' : 'Reply' }}
    </button>
    @endif 

    <!-- Reply Form -->
    @if ($ideaFeedBack->id ==$showForm)
        <div  class="space-y-2">
            <textarea 
                wire:model="comment"
                rows="3" 
                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" 
                placeholder="Write your reply here...">
            </textarea>

            @error('comment') 
                <p class="text-sm text-red-500">{{ $message }}</p> 
            @enderror

            <button  wire:click="createUserFeedback('{{$ideaFeedBack->id}}')"
               
                class="px-4 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                Send
            </button>
        </div>
    @endif

    @if (session()->has('message'))
        <p class="text-green-600 text-sm">{{ session('message') }}</p>
    @endif
</div>






@empty
    <div class="bg-white p-6 rounded-lg shadow-sm text-center border border-gray-200">
        <h3 class="text-base font-medium text-gray-800">No comments or feedback available</h3>
        <p class="text-sm text-gray-500 mt-1">Feedback will appear here once submitted.</p>
    </div>
@endforelse





        
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
                                    <button wire:click="approvalModalFuncion" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
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
                                    <textarea id="feedback" wire:model="comment" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Explain why this idea is being rejected"></textarea>
                                    @error('comment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="link" class="block text-sm font-medium text-gray-700">Project Link</label>
                                    <input type="url" name="link" id="link" wire:model="link"  placeholder="https://example.com"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
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

                                <div class="mb-4">
                                    <label for="link" class="block text-sm font-medium text-gray-700">Project Link</label>
                                    <input type="url" name="link" id="link" wire:model="link"  placeholder="https://example.com"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
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




    <!-- modal  -->


    <div>
   
   @if($showModal)
   <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
       <div class="bg-white p-6 rounded-lg w-1/3">
           <h2 class="text-xl mb-4">Enter Your Content</h2>
           
           <textarea wire:model="projectDescription" class="w-full p-2 border border-gray-300 rounded" rows="5"></textarea>

           <div class="mt-4 flex justify-end space-x-2">
               <button wire:click="updateProjectIdea" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Submit</button>
               <button wire:click="toggleModal" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">Cancel</button>
           </div>
       </div>
   </div>
   @endif
</div>




<!-- update idea modal -->
<div id="createIdeaModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full flex items-center justify-center">

    <!-- Overlay / Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>

    <!-- Modal content -->
    <div class="relative w-full max-w-2xl max-h-full z-50">
        <div class="bg-white rounded-lg shadow xy:bg-gray-700">
            
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t xy:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 xy:text-white">
                    Update Project Idea
                </h3>
                <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center xy:hover:bg-gray-600 xy:hover:text-white"
                        data-modal-hide="createIdeaModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-6 space-y-6">
     <form wire:submit.prevent="updateProjectIdea">
        <!-- Title -->
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">
                Title <span class="text-red-500">*</span>
            </label>
            <input type="text" id="title" wire:model.defer="title"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   placeholder="Enter project title">
            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Idea Type -->
        <div class="mb-4">
            <label for="idea_type" class="block text-sm font-medium text-gray-700">
                Idea Type <span class="text-red-500">*</span>
            </label>
            <select id="idea_type" wire:model.defer="idea_type"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Select Type</option>
                <option value="technology">Technology</option>
                <option value="iot">IoT</option>
                <option value="health">Health</option>
                <option value="education">Education</option>
                <option value="agriculture">Agriculture</option>
                <option value="energy">Energy</option>
            </select>
            @error('idea_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700">
                Description <span class="text-red-500">*</span>
            </label>
            <textarea id="description" wire:model.defer="description" rows="5"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                      placeholder="Describe your project idea in detail"></textarea>
            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Update Idea
            </button>
        </div>
    </form>

            </div>
        </div>
    </div>
</div>







<!-- approval modal -->


@if ($approvalModal)
<div tabindex="-1" aria-hidden="false"
     class="fixed inset-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full flex items-center justify-center">

    <!-- Overlay / Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-40"
         wire:click="$set('approvalModal', false)"></div>

    <!-- Modal content -->
    <div class="relative w-full max-w-2xl max-h-full z-50">
        <div class="bg-white rounded-lg shadow xy:bg-gray-700">

            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t xy:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 xy:text-white">
                    Approve Idea
                </h3>
                <button type="button"
                        wire:click="$set('approvalModal', false)"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center xy:hover:bg-gray-600 xy:hover:text-white">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 14 14" aria-hidden="true">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <!-- Warning Icon and Note -->
                <div class="flex items-start bg-yellow-100 text-yellow-800 p-4 rounded-lg shadow-sm">
                    <svg class="w-6 h-6 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01M12 5a7 7 0 110 14 7 7 0 010-14z"/>
                    </svg>
                    <p class="text-sm">
                        <strong>Precaution:</strong> On approval, a project will be created under the user who submitted this idea.
                    </p>
                </div>

                <form wire:submit.prevent="approveIdea">
                    <!-- Select Hub -->
                    <div class="mb-4">
                        <label for="hub" class="block text-sm font-medium text-gray-700">
                            Select Hub <span class="text-red-500">*</span>
                        </label>
                        <select id="hub" wire:model.defer="hub_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select a hub</option>
                            @foreach ($hubs as $hub)
                                <option value="{{ $hub->id }}">{{ $hub->name }}</option>
                            @endforeach
                        </select>
                        @error('hub_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Select Supervisor -->
                    <div class="mb-4">
                        <label for="supervisor" class="block text-sm font-medium text-gray-700">
                            Assign Supervisor <span class="text-red-500">*</span>
                        </label>
                        <select id="supervisor" wire:model.defer="supervisor_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select a supervisor</option>
                            @foreach ($supervisors as $supervisor)
                                <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                            @endforeach
                        </select>
                        @error('supervisor_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Approve Idea & Create Project
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endif




</div>