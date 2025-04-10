<?php

namespace App\Livewire\Stage;

use App\Models\Stage;
use App\Models\StageSubmission;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public Stage $stage;
    public $content;
    public $feedback;
    public $showSubmissionForm = false;
    public $showFeedbackForm = false;

    protected $rules = [
        'content' => 'required|min:10',
        'feedback' => 'required|min:10',
    ];

    public function mount(Stage $stage)
    {
        $this->stage = $stage;
        
        // Load latest submission content if exists
        $latestSubmission = $this->stage->latestSubmission;
        if ($latestSubmission) {
            $this->content = $latestSubmission->content;
        }
    }

    public function toggleSubmissionForm()
    {
        $this->showSubmissionForm = !$this->showSubmissionForm;
    }

    public function toggleFeedbackForm()
    {
        $this->showFeedbackForm = !$this->showFeedbackForm;
    }

    public function submitStage()
    {
        $this->validate([
            'content' => 'required|min:10',
        ]);
        
        // Create submission
        $submission = $this->stage->submissions()->create([
            'user_id' => Auth::id(),
            'content' => $this->content,
            'status' => 'submitted',
        ]);
        
        // Update stage status
        $this->stage->status = 'submitted';
        $this->stage->save();
        
        // Notify supervisor
        $supervisor = $this->stage->project->supervisor()->first();
        if ($supervisor) {
            NotificationService::sendToUser(
                $supervisor,
                'Stage Submission',
                'A new submission has been made for stage "' . $this->stage->name . '" in project "' . $this->stage->project->title . '".',
                'View Stage',
                route('stages.show', $this->stage->id),
                'info'
            );
        }
        
        // Record in activity log
        auth()->user()->activities()->create([
            'name' => 'Stage Submission',
            'description' => 'Submitted work for stage: ' . $this->stage->name,
            'type' => 'stage',
            'project_id' => $this->stage->project_id,
            'issue_date' => now(),
        ]);
        
        session()->flash('message', 'Stage submitted successfully.');
        $this->showSubmissionForm = false;
    }

    public function approveStage()
    {
        // Update stage status
        $this->stage->status = 'approved';
        $this->stage->save();
        
        // Update last submission status
        $latestSubmission = $this->stage->latestSubmission;
        if ($latestSubmission) {
            $latestSubmission->status = 'approved';
            $latestSubmission->save();
        }
        
        // Notify submitter
        $submitter = $latestSubmission ? $latestSubmission->user : null;
        if ($submitter) {
            NotificationService::sendToUser(
                $submitter,
                'Stage Approved',
                'Your submission for stage "' . $this->stage->name . '" in project "' . $this->stage->project->title . '" has been approved.',
                'View Stage',
                route('stages.show', $this->stage->id),
                'success'
            );
        }
        
        // Notify project members
        NotificationService::sendToProjectMembers(
            $this->stage->project,
            'Stage Approved',
            'The stage "' . $this->stage->name . '" in project "' . $this->stage->project->title . '" has been approved.',
            'View Project',
            route('projects.show', $this->stage->project_id),
            'info',
            [$submitter->id ?? 0]
        );
        
        // Record in activity log
        auth()->user()->activities()->create([
            'name' => 'Stage Approved',
            'description' => 'Approved stage: ' . $this->stage->name,
            'type' => 'stage',
            'project_id' => $this->stage->project_id,
            'issue_date' => now(),
        ]);
        
        session()->flash('message', 'Stage approved successfully.');
    }

    public function returnStage()
    {
        $this->validate([
            'feedback' => 'required|min:10',
        ]);
        
        // Update stage status
        $this->stage->status = 'returned';
        $this->stage->save();
        
        // Update last submission status and add feedback
        $latestSubmission = $this->stage->latestSubmission;
        if ($latestSubmission) {
            $latestSubmission->status = 'returned';
            $latestSubmission->feedback = $this->feedback;
            $latestSubmission->save();
        }
        
        // Notify submitter
        $submitter = $latestSubmission ? $latestSubmission->user : null;
        if ($submitter) {
            NotificationService::sendToUser(
                $submitter,
                'Stage Returned for Updates',
                'Your submission for stage "' . $this->stage->name . '" in project "' . $this->stage->project->title . '" has been returned for updates with feedback: ' . $this->feedback,
                'View Stage',
                route('stages.show', $this->stage->id),
                'warning'
            );
        }
        
        // Record in activity log
        auth()->user()->activities()->create([
            'name' => 'Stage Returned',
            'description' => 'Returned stage for updates: ' . $this->stage->name,
            'type' => 'stage',
            'project_id' => $this->stage->project_id,
            'issue_date' => now(),
        ]);
        
        session()->flash('message', 'Stage returned for updates successfully.');
        $this->showFeedbackForm = false;
    }

    public function render()
    {
        $submissions = $this->stage->submissions()->with('user')->latest()->get();
        $latestSubmission = $this->stage->latestSubmission;
        $isSupervisor = false;
        
        // Check if current user is the supervisor
        $supervisor = $this->stage->project->supervisor()->first();
        if ($supervisor && $supervisor->id === Auth::id()) {
            $isSupervisor = true;
        }
        
        return view('livewire.stage.show', [
            'submissions' => $submissions,
            'latestSubmission' => $latestSubmission,
            'isSupervisor' => $isSupervisor,
        ]);
    }
}