<?php

namespace App\Livewire\ProjectIdea;

use Livewire\Component;
use App\Models\Project;
use App\Models\ProjectIdea;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
class Show extends Component
{

    public ProjectIdea $projectIdea;
    public $feedback;
    public $showFeedbackForm = false;
    public $qualificationRequest;
    public $showQualificationForm = false;

    protected $rules = [
        'feedback' => 'required|min:10',
        'qualificationRequest' => 'required|min:10',
    ];

    public function mount(ProjectIdea $projectIdea)
    {
        $this->projectIdea = $projectIdea;
    }

    public function showFeedback()
    {
        $this->showFeedbackForm = true;
        $this->showQualificationForm = false;
    }

    public function showQualification()
    {
        $this->showQualificationForm = true;
        $this->showFeedbackForm = false;
    }


    public function render()
    {
        return view('livewire.project-idea.show');
    }
}
