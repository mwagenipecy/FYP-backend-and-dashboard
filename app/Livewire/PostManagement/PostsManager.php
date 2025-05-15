<?php

namespace App\Livewire\PostManagement;


use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostsManager extends Component
{
    use WithPagination, WithFileUploads;

    public $posts;
    public $selectedPost = null;
    public $showCreateModal = false;
    public $showDetailModal = false;
    
    // Form fields
    public $title = '';
    public $content = '';
    public $excerpt = '';
    public $type = 'blog';
    public $status = 'draft';
    public $featured_image;
    public $images = [];
    public $tags = '';
    public $event_date;
    public $event_time;
    public $event_location = '';
    public $max_participants;
    public $requirements = '';
    public $is_featured = false;
    public $allow_comments = true;
    
    // Comment fields
    public $newComment = '';
    public $replyingTo = null;
    public $replyComment = '';
    
    // Search and filters
    public $search = '';
    public $typeFilter = '';
    public $statusFilter = '';
    
    protected $rules = [
        'title' => 'required|min:3|max:255',
        'content' => 'required|min:10',
        'type' => 'required|in:blog,event,activity',
        'status' => 'required|in:draft,published,archived',
        'featured_image' => 'nullable|image|max:2048',
        'event_date' => 'nullable|date',
        'event_time' => 'nullable',
        'max_participants' => 'nullable|integer|min:1',
    ];

    public function mount()
    {
        $this->loadPosts();
    }

    public function loadPosts()
    {
        $query = Post::with(['author', 'comments'])
            ->when($this->search, function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->when($this->typeFilter, function($q) {
                $q->where('type', $this->typeFilter);
            })
            ->when($this->statusFilter, function($q) {
                $q->where('status', $this->statusFilter);
            });

        // If user is not admin, only show their posts or published posts
        if (!auth()->user()->hasRole('admin')) {
            $query->where(function($q) {
                $q->where('created_by', auth()->id())
                  ->orWhere('status', 'published');
            });
        }

        $this->posts = $query->latest()->get();
    }

    public function updatedSearch()
    {
        $this->loadPosts();
    }

    public function updatedTypeFilter()
    {
        $this->loadPosts();
    }

    public function updatedStatusFilter()
    {
        $this->loadPosts();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
    }

    public function openDetailModal($postId)
    {
        $this->selectedPost = Post::with(['author', 'comments.user', 'comments.replies.user', 'participants.user'])
            ->find($postId);
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedPost = null;
        $this->newComment = '';
        $this->replyingTo = null;
        $this->replyComment = '';
    }

    public function save()
    {
        $this->validate();

        // Handle featured image upload
        $featuredImagePath = null;
        if ($this->featured_image) {
            $featuredImagePath = $this->featured_image->store('posts/featured', 'public');
        }

        // Handle tags
        $tagsArray = null;
        if ($this->tags) {
            $tagsArray = array_map('trim', explode(',', $this->tags));
        }

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'type' => $this->type,
            'status' => $this->status,
            'featured_image' => $featuredImagePath,
            'tags' => $tagsArray,
            'event_date' => $this->event_date,
            'event_time' => $this->event_time,
            'event_location' => $this->event_location,
            'max_participants' => $this->max_participants,
            'requirements' => $this->requirements,
            'is_featured' => $this->is_featured,
            'allow_comments' => $this->allow_comments,
            'created_by' => auth()->id(),
        ];

        // Set published_at if status is published
        if ($this->status === 'published') {
            $data['published_at'] = now();
        }

        Post::create($data);

        $this->closeCreateModal();
        $this->loadPosts();
        session()->flash('message', 'Post created successfully!');
    }

    public function addComment()
    {
        $this->validate([
            'newComment' => 'required|min:1|max:1000'
        ]);

        PostComment::create([
            'post_id' => $this->selectedPost->id,
            'user_id' => auth()->id(),
            'comment' => $this->newComment,
            'status' => 'approved'
        ]);

        $this->newComment = '';
        $this->selectedPost->refresh();
    }

    public function addReply($commentId)
    {
        $this->validate([
            'replyComment' => 'required|min:1|max:1000'
        ]);

        PostComment::create([
            'post_id' => $this->selectedPost->id,
            'user_id' => auth()->id(),
            'comment' => $this->replyComment,
            'parent_id' => $commentId,
            'status' => 'approved'
        ]);

        $this->replyComment = '';
        $this->replyingTo = null;
        $this->selectedPost->refresh();
    }

    public function startReply($commentId)
    {
        $this->replyingTo = $commentId;
        $this->replyComment = '';
    }

    public function cancelReply()
    {
        $this->replyingTo = null;
        $this->replyComment = '';
    }

    public function joinEvent($postId)
    {
        $post = Post::find($postId);
        
        if ($post && $post->canUserParticipate(auth()->user())) {
            $post->registerParticipant(auth()->user());
            $this->selectedPost->refresh();
            session()->flash('message', 'Successfully registered for the event!');
        } else {
            session()->flash('error', 'Unable to register for this event.');
        }
    }

    public function resetForm()
    {
        $this->title = '';
        $this->content = '';
        $this->excerpt = '';
        $this->type = 'blog';
        $this->status = 'draft';
        $this->featured_image = null;
        $this->images = [];
        $this->tags = '';
        $this->event_date = null;
        $this->event_time = null;
        $this->event_location = '';
        $this->max_participants = null;
        $this->requirements = '';
        $this->is_featured = false;
        $this->allow_comments = true;
    }

    public function render()
    {
        return view('livewire.post-management.posts-manager');
    }
}

