<div>
<div class="max-w-6xl mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b">
            <h2 class="text-2xl font-bold text-gray-900">Dynamic Question Builder</h2>
            <p class="text-gray-600 mt-1">Create and manage dynamic form questions</p>
        </div>

        @if (session()->has('message'))
            <div class="mx-6 mt-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                {{ session('message') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
            <!-- Question Form -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ $editingId ? 'Edit Question' : 'Add New Question' }}
                </h3>

                <div>
                    <label for="question" class="block text-sm font-medium text-gray-700 mb-2">
                        Question Text *
                    </label>
                    <input
                        wire:model="question"
                        type="text"
                        id="question"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('question') border-red-500 @enderror"
                        placeholder="Enter your question..."
                    >
                    @error('question')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description (Optional)
                    </label>
                    <textarea
                        wire:model="description"
                        id="description"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Additional instructions or context..."
                    ></textarea>
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        Question Type *
                    </label>
                    <select
                        wire:model.live="type"
                        id="type"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        @foreach($questionTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                @if(in_array($type, ['radio', 'checkbox', 'select']))
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Options *
                        </label>
                        
                        <div class="flex gap-2 mb-3">
                            <input
                                wire:model="newOption"
                                wire:keydown.enter="addOption"
                                type="text"
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter an option..."
                            >
                            <button
                                wire:click="addOption"
                                type="button"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                Add
                            </button>
                        </div>

                        @error('options')
                            <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                        @enderror

                        @if(count($options) > 0)
                            <div class="space-y-2 max-h-32 overflow-y-auto">
                                @foreach($options as $index => $option)
                                    <div class="flex items-center justify-between bg-gray-50 px-3 py-2 rounded">
                                        <span class="text-sm">{{ $option }}</span>
                                        <button
                                            wire:click="removeOption({{ $index }})"
                                            type="button"
                                            class="text-red-600 hover:text-red-800 text-sm"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <div>
                    <label class="flex items-center">
                        <input
                            wire:model="required"
                            type="checkbox"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                        <span class="ml-2 text-sm text-gray-600">Required field</span>
                    </label>
                </div>

                <div class="flex gap-3">
                    <button
                        wire:click="save"
                        type="button"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        {{ $editingId ? 'Update Question' : 'Add Question' }}
                    </button>

                    @if($editingId)
                        <button
                            wire:click="resetForm"
                            type="button"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        >
                            Cancel Edit
                        </button>
                    @endif
                </div>
            </div>

            <!-- Questions List -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    Current Questions ({{ $questions->count() }})
                </h3>

                @if($questions->count() > 0)
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach($questions as $q)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900 mb-1">{{ $q->question }}</h4>
                                        
                                        @if($q->description)
                                            <p class="text-sm text-gray-600 mb-2">{{ $q->description }}</p>
                                        @endif

                                        <div class="flex flex-wrap gap-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $questionTypes[$q->type] }}
                                            </span>
                                            
                                            @if($q->required)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Required
                                                </span>
                                            @endif

                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Order: {{ $q->order }}
                                            </span>
                                        </div>

                                        @if($q->options)
                                            <div class="mt-2">
                                                <p class="text-xs text-gray-500">Options:</p>
                                                <p class="text-sm text-gray-700">{{ implode(', ', $q->options) }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="ml-4 flex space-x-2">
                                        <button
                                            wire:click="edit({{ $q->id }})"
                                            class="text-blue-600 hover:text-blue-900 text-sm font-medium"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            wire:click="delete({{ $q->id }})"
                                            wire:confirm="Are you sure you want to delete this question?"
                                            class="text-red-600 hover:text-red-900 text-sm font-medium"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No questions yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating your first question.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

</div>
