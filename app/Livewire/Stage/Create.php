<?php

namespace App\Http\Livewire\Project\Stage;

use App\Models\ProjectPhase;
use App\Models\Stage;
use App\Services\NotificationService;
use Livewire\Component;

class Create extends Component
{
    public ProjectPhase $phase;
    public $name;
    public $description;
    public $showForm = false;

    protected $rules = [
        'name' => 'required|min:3|max:45',
        'description' => 'nullable',
    ];

    public function mount(ProjectPhase $phase)
    {
        $this->phase = $phase;
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->reset(['name', 'description']);
    }

    public function save()
    {
        $this->validate();
        
        // Get the highest order value for stages in this phase
        $maxOrder = $this->phase->stages()->max('order') ?? 0;
        
        // Create new stage
        $stage = $this->phase->stages()->create([
            'name' => $this->name,
            'description' => $this->description,
            'project_id' => $this->phase->project_id,
            'status' => 'pending',
            'order' => $maxOrder + 1,
        ]);
        
        // Notify project supervisor
        $supervisor = $this->phase->project->supervisor()->first();
        if ($supervisor) {
            NotificationService::sendToUser(
                $supervisor,
                'New Project Stage Created',
                'A new stage "' . $stage->name . '" has been created in phase "' . $this->phase->name . '" for project "' . $this->phase->project->title . '".',
                'View Project',
                route('projects.show', $this->phase->project_id),
                'info'
            );
        }
        
        // Notify project members
        NotificationService::sendToProjectMembers(
            $this->phase->project,
            'New Project Stage Created',
            'A new stage "' . $stage->name . '" has been created in phase "' . $this->phase->name . '" for project "' . $this->phase->project->title . '".',
            'View Project',
            route('projects.show', $this->phase->project_id),
            'info'
        );
        
        session()->flash('message', 'Stage created successfully.');
        $this->toggleForm();
        $this->emit('stageCreated');
    }

    public function render()
    {
        return view('livewire.project.stage.create');
    }
}
