<?php

namespace App\Livewire\PostManagement;




use Livewire\Component;
use App\Models\Post;
use App\Models\PostComment;

class PostsList extends Component
{
    public $posts;
    public $selectedPost = null;
    public $showDetailModal = false;
    
    // Comment fields
    public $newComment = '';
    public $replyingTo = null;
    public $replyComment = '';
    
    // Filters
    public $typeFilter = '';
    public $search = '';

    public function mount()
    {
        $this->loadPosts();
    }

    public function loadPosts()
    {
        $query = Post::published()
            ->with(['author', 'comments', 'participants'])
            ->when($this->search, function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $this->search . '%');
            })
            ->when($this->typeFilter, function($q) {
                $q->where('type', $this->typeFilter);
            });

        $this->posts = $query->latest('published_at')->get();
    }

    public function updatedSearch()
    {
        $this->loadPosts();
    }

    public function updatedTypeFilter()
    {
        $this->loadPosts();
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

    public function addComment()
    {
        if (!auth()->check()) {
            session()->flash('error', 'You must be logged in to comment.');
            return;
        }

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
        session()->flash('message', 'Comment added successfully!');
    }

    public function addReply($commentId)
    {
        if (!auth()->check()) {
            session()->flash('error', 'You must be logged in to reply.');
            return;
        }

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
        session()->flash('message', 'Reply added successfully!');
    }

    public function startReply($commentId)
    {
        if (!auth()->check()) {
            session()->flash('error', 'You must be logged in to reply.');
            return;
        }
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
        if (!auth()->check()) {
            session()->flash('error', 'You must be logged in to join events.');
            return;
        }

        $post = Post::find($postId);
        
        if ($post && $post->canUserParticipate(auth()->user())) {
            $post->registerParticipant(auth()->user());
            $this->selectedPost->refresh();
            $this->loadPosts(); // Refresh posts list
            session()->flash('message', 'Successfully registered for the event!');
        } else {
            session()->flash('error', 'Unable to register for this event.');
        }
    }

    public function render()
    {
        return view('livewire.post-management.posts-list');
    }
}



