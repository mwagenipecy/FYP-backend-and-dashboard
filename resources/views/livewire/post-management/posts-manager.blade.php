<div>

<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Search and Filters -->
        <div class="lg:w-1/4">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Filters</h3>
                
                <!-- Search -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" wire:model.live="search" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2"
                           placeholder="Search posts...">
                </div>

                <!-- Type Filter -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select wire:model.live="typeFilter" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">All Types</option>
                        <option value="blog">Blog</option>
                        <option value="event">Event</option>
                        <option value="activity">Activity</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select wire:model.live="statusFilter" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">All Status</option>
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>

                <!-- Create New Post Button -->
                <button wire:click="openCreateModal" 
                        class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create New Post
                </button>
            </div>
        </div>
    
    



<!-- Posts List -->
<div class="lg:w-3/4">
            <div class="space-y-6">
                @forelse($posts as $post)
                    <div class="bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $post->title }}</h2>
                                    <div class="flex items-center space-x-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                   bg-{{ $post->type_color }}-100 text-{{ $post->type_color }}-800">
                                            {{ ucfirst($post->type) }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                   bg-{{ $post->status_color }}-100 text-{{ $post->status_color }}-800">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                        @if($post->is_featured)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @if($post->featured_image)
                                    <img src="{{ Storage::url($post->featured_image) }}" 
                                         alt="{{ $post->title }}"
                                         class="w-24 h-24 object-cover rounded-lg">
                                @endif
                            </div>

                            <p class="text-gray-600 mb-4">{{ $post->excerpt }}</p>

                            @if($post->type === 'event')
                                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @if($post->event_date_time)
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $post->event_date_time }}
                                            </div>
                                        @endif
                                        @if($post->event_location)
                                            <div class="flex items-center text-sm text-gray-600">
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
                                                {{ $post->participant_count }} / {{ $post->max_participants }} participants
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-500">
                                    By {{ $post->author->name }} • {{ $post->formatted_published_date }}
                                    @if($post->comments->count() > 0)
                                        <span class="ml-2">• {{ $post->comments->count() }} comments</span>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    @if($post->type === 'event' && $post->status === 'published' && $post->canUserParticipate(auth()->user()))
                                        <button wire:click="joinEvent({{ $post->id }})"
                                                class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                                            Join Event
                                        </button>
                                    @endif
                                    <button wire:click="openDetailModal({{ $post->id }})"
                                            class="px-3 py-1 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No posts found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new post.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>






<!-- Create Post Modal -->
@if($showCreateModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Create New Post</h3>
                    
                    <form wire:submit.prevent="save" class="space-y-4">
                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" wire:model="title" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2"
                                   placeholder="Enter post title">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Content -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                            <textarea wire:model="content" rows="5"
                                      class="w-full border border-gray-300 rounded-md px-3 py-2"
                                      placeholder="Write your content here..."></textarea>
                            @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Excerpt -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Excerpt (Optional)</label>
                            <textarea wire:model="excerpt" rows="2"
                                      class="w-full border border-gray-300 rounded-md px-3 py-2"
                                      placeholder="Brief description of the post"></textarea>
                        </div>

                        <!-- Type and Status -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                <select wire:model="type" class="w-full border border-gray-300 rounded-md px-3 py-2">
                                    <option value="blog">Blog</option>
                                    <option value="event">Event</option>
                                    <option value="activity">Activity</option>
                                </select>
                                @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select wire:model="status" class="w-full border border-gray-300 rounded-md px-3 py-2">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                    <option value="archived">Archived</option>
                                </select>
                                @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Featured Image</label>
                            <input type="file" wire:model="featured_image" accept="image/*"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2">
                            @error('featured_image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Tags -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tags (comma separated)</label>
                            <input type="text" wire:model="tags" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2"
                                   placeholder="tag1, tag2, tag3">
                        </div>















                        <!-- Event Specific Fields -->
                        @if($type === 'event')
                            <div class="border-t pt-4">
                                <h4 class="text-md font-medium text-gray-900 mb-3">Event Details</h4>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Event Date</label>
                                        <input type="date" wire:model="event_date" 
                                               class="w-full border border-gray-300 rounded-md px-3 py-2">
                                        @error('event_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Event Time</label>
                                        <input type="time" wire:model="event_time" 
                                               class="w-full border border-gray-300 rounded-md px-3 py-2">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                    <input type="text" wire:model="event_location" 
                                           class="w-full border border-gray-300 rounded-md px-3 py-2"
                                           placeholder="Event location">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Participants</label>
                                    <input type="number" wire:model="max_participants" 
                                           class="w-full border border-gray-300 rounded-md px-3 py-2"
                                           placeholder="Maximum number of participants">
                                    @error('max_participants') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Requirements</label>
                                    <textarea wire:model="requirements" rows="3"
                                              class="w-full border border-gray-300 rounded-md px-3 py-2"
                                              placeholder="Any special requirements for participants"></textarea>
                                </div>
                            </div>
                        @endif

                        <!-- Options -->
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="is_featured" class="mr-2">
                                <span class="text-sm text-gray-700">Mark as featured</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="allow_comments" class="mr-2">
                                <span class="text-sm text-gray-700">Allow comments</span>
                            </label>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3">
                            <button type="button" wire:click="closeCreateModal"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Save Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif










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
                                    </div>
                                @endif
                                @if($selectedPost->canUserParticipate(auth()->user()))
                                    <div class="md:col-span-2">
                                        <button wire:click="joinEvent({{ $selectedPost->id }})"
                                                class="w-full md:w-auto px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                            Join Event
                                        </button>
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
                            <h4 class="text-lg font-semibold mb-3">Participants</h4>
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
                                            <p class="text-xs text-gray-500">{{ $participant->created_at->diffForHumans() }}</p>
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
                                            <button wire:click="startReply({{ $comment->id }})"
                                                    class="text-indigo-600 text-sm hover:text-indigo-700">
                                                Reply
                                            </button>
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
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>


    
    
    
    
    
    
    </div>
