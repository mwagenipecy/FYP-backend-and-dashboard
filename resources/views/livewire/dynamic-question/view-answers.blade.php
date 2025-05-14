<div>
<div class="max-w-7xl mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b">
            <h2 class="text-2xl font-bold text-gray-900">View All Answers</h2>
            <p class="text-gray-600 mt-1">Review all submitted answers</p>
        </div>

        <!-- Filters -->
        <div class="px-6 py-4 bg-gray-50 border-b">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="selectedQuestion" class="block text-sm font-medium text-gray-700 mb-1">
                        Filter by Question
                    </label>
                    <select wire:model.live="selectedQuestion" id="selectedQuestion" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Questions</option>
                        @foreach($questions as $question)
                            <option value="{{ $question->id }}">{{ Str::limit($question->question, 50) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="searchEmail" class="block text-sm font-medium text-gray-700 mb-1">
                        Search by Email
                    </label>
                    <input
                        wire:model.live.debounce.300ms="searchEmail"
                        type="email"
                        id="searchEmail"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter email to search..."
                    >
                </div>
            </div>
        </div>

        <!-- Answers List -->
        <div class="divide-y divide-gray-200">
            @forelse($answers as $answer)
                <div class="px-6 py-4">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $answer->question->question }}</h3>
                            
                            <div class="text-sm text-gray-600 mb-3">
                                <strong>Student:</strong> {{ $answer->student_name }} ({{ $answer->student_email }})
                            </div>

                            <div class="bg-gray-50 p-3 rounded-lg">
                                @if($answer->question->type === 'file' && $answer->hasFiles())
                                    <p class="text-sm text-gray-700 mb-2"><strong>Files uploaded:</strong></p>
                                    <div class="space-y-1">
                                        @foreach($answer->file_paths as $filePath)
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <a href="{{ Storage::url($filePath) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                                                    {{ basename($filePath) }}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-700">{{ $answer->display_value ?: 'No answer provided' }}</p>
                                @endif
                            </div>

                            <div class="text-xs text-gray-500 mt-2">
                                Answered: {{ $answer->answered_at->format('M d, Y \a\t H:i A') }}
                            </div>
                        </div>

                        <div class="ml-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($answer->question->type) }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No answers found</h3>
                    <p class="mt-1 text-sm text-gray-500">No answers match your current filters.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($answers->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t">
                {{ $answers->links() }}
            </div>
        @endif
    </div>
</div>

</div>
