<div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($posts as $post)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                <!-- Featured Image -->
                @if($post->featured_image)
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="{{ Storage::url($post->featured_image) }}" 
                             alt="{{ $post->title }}"
                             class="w-full h-48 object-cover">
                    </div>
                @endif

                <div class="p-6">
                    <!-- Post Type Badge -->
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                   bg-{{ $post->type_color }}-100 text-{{ $post->type_color }}-800">
                            {{ ucfirst($post->type) }}
                        </span>
                        @if($post->is_featured)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                ⭐ Featured
                            </span>
                        @endif
                    </div>

                    <!-- Title -->
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $post->title }}</h3>

                    <!-- Excerpt -->
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $post->excerpt }}</p>

                    <!-- Event Info -->
                    @if($post->type === 'event')
                        <div class="bg-gray-50 rounded-lg p-3 mb-4">
                            @if($post->event_date_time)
                                <div class="flex items-center text-sm text-gray-600 mb-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $post->event_date_time }}
                                </div>
                            @endif
                            @if($post->event_location)
                                <div class="flex items-center text-sm text-gray-600 mb-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $post->event_location }}
                                </div>
                            @endif
                            @if($post->max_participants)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197v1a6 6 0 00-12 0v-1"></path>
                                    </svg>
                                    {{ $post->participant_count }}/{{ $post->max_participants }} participants
                                    @if($post->spots_remaining <= 5 && $post->spots_remaining > 0)
                                        <span class="ml-2 text-orange-600 font-medium">({{ $post->spots_remaining }} spots left!)</span>
                                    @elseif($post->spots_remaining == 0)
                                        <span class="ml-2 text-red-600 font-medium">(Full)</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Tags -->
                    @if($post->tags && count($post->tags) > 0)
                        <div class="flex flex-wrap gap-1 mb-4">
                            @foreach(array_slice($post->tags, 0, 3) as $tag)
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">#{{ $tag }}</span>
                            @endforeach
                            @if(count($post->tags) > 3)
                                <span class="text-xs text-gray-500">+{{ count($post->tags) - 3 }} more</span>
                            @endif
                        </div>
                    @endif

                    <!-- Footer -->
                    <div class="flex items-center justify-between">
                        <div class="text-xs text-gray-500">
                            {{ $post->formatted_published_date }}
                            @if($post->comments->count() > 0)
                                <span class="ml-2">• {{ $post->comments->count() }} comments</span>
                            @endif
                        </div>
                        <div class="flex space-x-2">
                            @if($post->type === 'event' && $post->canUserParticipate(auth()->user()))
                                <button wire:click="joinEvent({{ $post->id }})"
                                        class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition-colors">
                                    Join Event
                                </button>
                            @endif
                            <button wire:click="openDetailModal({{ $post->id }})"
                                    class="px-3 py-1 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700 transition-colors">
                                Read More
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 011 1v1m-6 4h6m-6 4h6m-6 4h6" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No posts available</h3>
                <p class="mt-1 text-sm text-gray-500">Check back later for new content.</p>
            </div>
        @endforelse
    </div>

    <!-- Post Detail Modal -->
    @if($showDetailModal && $selectedPost)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-4/5 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $selectedPost->title }}</h2>
                            <div class="flex items-center space-x-4 mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                           bg-{{ $selectedPost->type_color }}-100 text-{{ $selectedPost->type_color }}-800">
                                    {{ ucfirst($selectedPost->type) }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    By {{ $selectedPost->author->name }} • {{ $selectedPost->formatted_published_date }}
                                </span>
                                @if($selectedPost->is_featured)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        ⭐ Featured
                                    </span>
                                @endif
                            </div>
                        </div>
                        <button wire:click="closeDetailModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Featured Image -->
                    @if($selectedPost->featured_image)
                        <div class="mb-6">
                            <img src="{{ Storage::url($selectedPost->featured_image) }}" 
                                 alt="{{ $selectedPost->title }}"
                                 class="w-full h-64 object-cover rounded-lg">
                        </div>
                    @endif

                    <!-- Event Details -->
                    @if($selectedPost->type === 'event')
                        <div class="bg-blue-50 rounded-lg p-4 mb-6">
                            <h3 class="text-lg font-semibold mb-3">Event Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($selectedPost->event_date_time)
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="font-medium">{{ $selectedPost->event_date_time }}</span>
                                    </div>
                                @endif
                                @if($selectedPost->event_location)
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>{{ $selectedPost->event_location }}</span>
                                    </div>
                                @endif
                                @if($selectedPost->max_participants)
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197v1a6 6 0 00-12 0v-1"></path>
                                        </svg>
                                        <span>{{ $selectedPost->participant_count }} / {{ $selectedPost->max_participants }} participants</span>
                                        @if($selectedPost->spots_remaining <= 5 && $selectedPost->spots_remaining > 0)
                                            <span class="ml-2 text-orange-600 font-medium">({{ $selectedPost->spots_remaining }} spots left!)</span>
                                        @elseif($selectedPost->spots_remaining == 0)
                                            <span class="ml-2 text-red-600 font-medium">(Event Full)</span>
                                        @endif
                                    </div>
                                @endif
                                @if($selectedPost->canUserParticipate(auth()->user()))
                                    <div class="md:col-span-2">
                                        <button wire:click="joinEvent({{ $selectedPost->id }})"
                                                class="w-full md:w-auto px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                            Join Event
                                        </button>
                                    </div>
                                @elseif(auth()->check() && $selectedPost->participants->where('user_id', auth()->id())->first())
                                    <div class="md:col-span-2">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="text-green-600 font-medium">You're registered for this event</span>
                                        </div>
                                    </div>
                                @elseif(!auth()->check())
                                    <div class="md:col-span-2">
                                        <p class="text-gray-600 text-sm">Please log in to register for this event.</p>
                                    </div>
                                @endif
                            </div>
                            @if($selectedPost->requirements)
                                <div class="mt-4">
                                    <h4 class="font-medium mb-2">Requirements:</h4>
                                    <p class="text-gray-700">{{ $selectedPost->requirements }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="prose max-w-none mb-8">
                        {!! nl2br(e($selectedPost->content)) !!}
                    </div>

                    <!-- Tags -->
                    @if($selectedPost->tags)
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Tags:</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($selectedPost->tags as $tag)
                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">#{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Participants (for events) -->
                    @if($selectedPost->type === 'event' && $selectedPost->participants->count() > 0)
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold mb-3">Participants ({{ $selectedPost->participants->count() }})</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($selectedPost->participants as $participant)
                                    <div class="flex items-center space-x-2 bg-gray-50 rounded-lg p-3">
                                        <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center">
                                            <span class="text-xs font-medium text-white">
                                                {{ substr($participant->user->name, 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium">{{ $participant->user->name }}</p>
                                            <p class="text-xs text-gray-500">Registered {{ $participant->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Comments Section -->
                    @if($selectedPost->allow_comments)
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold mb-4">Comments ({{ $selectedPost->comments->count() }})</h3>
                            
                            <!-- Add Comment -->
                            @auth
                                <div class="mb-6">
                                    <textarea wire:model="newComment" rows="3"
                                              class="w-full border border-gray-300 rounded-md px-3 py-2"
                                              placeholder="Write a comment..."></textarea>
                                    @error('newComment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    <div class="mt-2">
                                        <button wire:click="addComment"
                                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                            Add Comment
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                                    <p class="text-gray-600">Please <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700">log in</a> to leave a comment.</p>
                                </div>
                            @endauth

                            <!-- Comments List -->
                            <div class="space-y-4">
                                @foreach($selectedPost->comments as $comment)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-medium text-white">
                                                        {{ substr($comment->user->name, 0, 2) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <p class="font-medium">{{ $comment->user->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                            @auth
                                                <button wire:click="startReply({{ $comment->id }})"
                                                        class="text-indigo-600 text-sm hover:text-indigo-700">
                                                    Reply
                                                </button>
                                            @endauth
                                        </div>
                                        <p class="mt-3 text-gray-700">{{ $comment->comment }}</p>

                                        <!-- Reply Form -->
                                        @if($replyingTo === $comment->id)
                                            <div class="mt-4 pl-8">
                                                <textarea wire:model="replyComment" rows="2"
                                                          class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                                                          placeholder="Write a reply..."></textarea>
                                                @error('replyComment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                <div class="mt-2 space-x-2">
                                                    <button wire:click="addReply({{ $comment->id }})"
                                                            class="px-3 py-1 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                                                        Reply
                                                    </button>
                                                    <button wire:click="cancelReply"
                                                            class="px-3 py-1 bg-gray-300 text-gray-700 text-sm rounded hover:bg-gray-400">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Replies -->
                                        @if($comment->replies->count() > 0)
                                            <div class="mt-4 pl-8 space-y-3">
                                                @foreach($comment->replies as $reply)
                                                    <div class="bg-white rounded-lg p-3">
                                                        <div class="flex items-center space-x-2">
                                                            <div class="w-6 h-6 bg-gray-400 rounded-full flex items-center justify-center">
                                                                <span class="text-xs font-medium text-white">
                                                                    {{ substr($reply->user->name, 0, 2) }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm font-medium">{{ $reply->user->name }}</p>
                                                                <p class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                                                            </div>
                                                        </div>
                                                        <p class="mt-2 text-sm text-gray-700">{{ $reply->comment }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach

                                @if($selectedPost->comments->count() === 0)
                                    <div class="text-center py-8">
                                        <p class="text-gray-500">No comments yet. Be the first to comment!</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

<style>
.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.line-clamp-3 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}
</style>

</div>
