<?php

namespace App\Livewire\ProjectIdea;

use App\Models\ProjectIdea;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $title;
    public $description;
    public $idea_type;
    
    protected $rules = [
        'title' => 'required|min:3|max:45',
        'description' => 'required|min:10',
        'idea_type'=>'required'
    ];

    public function submit()
    {
        $this->validate();
        
        $projectIdea = ProjectIdea::create([
            'title' => $this->title,
            'description' => $this->description,
            'status' => 'submitted',
            'user_id' => Auth::id(),
            'idea_type'=>$this->idea_type
        ]);

        // Record in activity log
        $projectIdea->user->activities()->create([
            'name' => 'Project Idea Submitted',
            'description' => 'Submitted a new project idea: ' . $projectIdea->title,
            'type' => 'project_idea',
            'issue_date' => now(),
        ]);



        // Find admin/reviewers to notify
        $reviewers = \App\Models\User::whereHas('role', function ($query) {
            $query->where('name', 'Admin')->orWhere('name', 'Reviewer');
        })->get();


       

        // Notify reviewers about new idea
        if ($reviewers->count() > 0) {
            NotificationService::sendToMultipleUsers(
                $reviewers->toArray(),
                'New Project Idea Submitted',
                'A new project idea has been submitted: ' . $projectIdea->title,
                'Review Idea',
                route('project-ideas.show', $projectIdea->id),
                'info'
            );
        }

        $this->reset(['title', 'description']);
        session()->flash('message', 'Project idea submitted successfully!');
        
        return redirect()->route('idea.list');
    }

    public function render()
    {
        return view('livewire.project-idea.create');
    }
}
