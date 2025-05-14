<div id="application">
<div class="max-w-4xl mx-auto p-6">
    @if($isSubmitted)
        <!-- Success Message -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-8 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Thank You!</h2>
                <p class="mt-2 text-gray-600">Your answers have been submitted successfully.</p>
                <button wire:click="resetForm" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Submit Another Response
                </button>
            </div>
        </div>
    @else
        <!-- Question Form -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h2 class="text-2xl font-bold text-gray-900">Answer Questions</h2>
                <p class="text-gray-600 mt-1">Please answer the following questions</p>
            </div>

            <!-- Progress Bar -->
            <div class="px-6 py-4 bg-gray-50 border-b">
                <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                    <span>Step {{ $currentStep }} of {{ $totalSteps }}</span>
                    <span>{{ $progressPercentage }}% Complete</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $progressPercentage }}%"></div>
                </div>
            </div>

            @if (session()->has('message'))
                <div class="mx-6 mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <div class="px-6 py-6">
                @if($currentStep === 1)
                    <!-- Student Information Step -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900">Your Information</h3>
                        
                        <div>
                            <label for="studentName" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name *
                            </label>
                            <input
                                wire:model="studentName"
                                type="text"
                                id="studentName"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('studentName') border-red-500 @enderror"
                                placeholder="Enter your full name"
                            >
                            @error('studentName')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="studentEmail" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address *
                            </label>
                            <input
                                wire:model="studentEmail"
                                type="email"
                                id="studentEmail"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('studentEmail') border-red-500 @enderror"
                                placeholder="Enter your email address"
                            >
                            @error('studentEmail')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @elseif($currentQuestion)
                    <!-- Question Step -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                Question {{ $currentStep - 1 }} of {{ $totalSteps - 1 }}
                            </h3>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">
                                    {{ $currentQuestion->question }}
                                    @if($currentQuestion->required)
                                        <span class="text-red-500">*</span>
                                    @endif
                                </h4>
                                
                                @if($currentQuestion->description)
                                    <p class="text-sm text-gray-600 mb-4">{{ $currentQuestion->description }}</p>
                                @endif

                                <!-- Different input types based on question type -->
                                @if($currentQuestion->type === 'text')
                                    <input
                                        wire:model="answers.{{ $currentQuestion->id }}"
                                        type="text"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('answers.' . $currentQuestion->id) border-red-500 @enderror"
                                        placeholder="Enter your answer..."
                                    >

                                @elseif($currentQuestion->type === 'textarea')
                                    <textarea
                                        wire:model="answers.{{ $currentQuestion->id }}"
                                        rows="4"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('answers.' . $currentQuestion->id) border-red-500 @enderror"
                                        placeholder="Enter your answer..."
                                    ></textarea>

                                @elseif($currentQuestion->type === 'email')
                                    <input
                                        wire:model="answers.{{ $currentQuestion->id }}"
                                        type="email"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('answers.' . $currentQuestion->id) border-red-500 @enderror"
                                        placeholder="Enter email address..."
                                    >

                                @elseif($currentQuestion->type === 'date')
                                    <input
                                        wire:model="answers.{{ $currentQuestion->id }}"
                                        type="date"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('answers.' . $currentQuestion->id) border-red-500 @enderror"
                                    >

                                @elseif($currentQuestion->type === 'file')
                                    <input
                                        wire:model="files.{{ $currentQuestion->id }}"
                                        type="file"
                                        multiple
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('files.' . $currentQuestion->id) border-red-500 @enderror"
                                    >
                                    @if(isset($files[$currentQuestion->id]) && count($files[$currentQuestion->id]) > 0)
                                        <div class="mt-3 space-y-2">
                                            @foreach($files[$currentQuestion->id] as $index => $file)
                                                <div class="flex items-center justify-between bg-gray-100 px-3 py-2 rounded">
                                                    <span class="text-sm text-gray-700">{{ $file->getClientOriginalName() }}</span>
                                                    <button
                                                        wire:click="removeFile({{ $currentQuestion->id }}, {{ $index }})"
                                                        type="button"
                                                        class="text-red-600 hover:text-red-800 text-sm"
                                                    >
                                                        Remove
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                @elseif($currentQuestion->type === 'radio')
                                    <div class="space-y-3">
                                        @foreach($currentQuestion->options as $option)
                                            <label class="flex items-center">
                                                <input
                                                    wire:model="answers.{{ $currentQuestion->id }}"
                                                    type="radio"
                                                    value="{{ $option }}"
                                                    class="mr-3 text-blue-600 border-gray-300 focus:ring-blue-500"
                                                >
                                                <span class="text-gray-700">{{ $option }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                @elseif($currentQuestion->type === 'checkbox')
                                    <div class="space-y-3">
                                        @foreach($currentQuestion->options as $option)
                                            <label class="flex items-center">
                                                <input
                                                    wire:model="answers.{{ $currentQuestion->id }}"
                                                    type="checkbox"
                                                    value="{{ $option }}"
                                                    class="mr-3 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                >
                                                <span class="text-gray-700">{{ $option }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                @elseif($currentQuestion->type === 'select')
                                    <select
                                        wire:model="answers.{{ $currentQuestion->id }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('answers.' . $currentQuestion->id) border-red-500 @enderror"
                                    >
                                        <option value="">Select an option...</option>
                                        @foreach($currentQuestion->options as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                @endif

                                @error('answers.' . $currentQuestion->id)
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                                @error('files.' . $currentQuestion->id)
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                    @if($currentStep > 1)
                        <button
                            wire:click="previousStep"
                            type="button"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        >
                            Previous
                        </button>
                    @else
                        <div></div>
                    @endif

                    @if($currentStep < $totalSteps)
                        <button
                            wire:click="nextStep"
                            type="button"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            Next
                        </button>
                    @else
                        <button
                            wire:click="submitAnswers"
                            type="button"
                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                        >
                            Submit Answers
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>



</div>
