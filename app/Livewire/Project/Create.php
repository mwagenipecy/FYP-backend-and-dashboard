<?php

namespace App\Livewire\Project;

use App\Models\Project;
use App\Models\ProjectPhase;
use App\Services\NotificationService;
use Livewire\Component;

class Create extends Component
{
    public Project $project;
    public $name;
    public $description;
    public $showForm = false;

    protected $rules = [
        'name' => 'required|min:3|max:45',
        'description' => 'nullable',
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->reset(['name', 'description']);
    }

    public function save()
    {
        $this->validate();
        
        // Get the highest order value
        $maxOrder = $this->project->phases()->max('order') ?? 0;
        
        // Create new phase
        $phase = $this->project->phases()->create([
            'name' => $this->name,
            'description' => $this->description,
            'order' => $maxOrder + 1,
        ]);
        
        // Notify project supervisor
        $supervisor = $this->project->supervisor()->first();
        if ($supervisor) {
            NotificationService::sendToUser(
                $supervisor,
                'New Project Phase Created',
                'A new phase "' . $phase->name . '" has been created for project "' . $this->project->title . '".',
                'View Project',
                route('projects.show', $this->project->id),
                'info'
            );
        }
        
        // Notify project members
        NotificationService::sendToProjectMembers(
            $this->project,
            'New Project Phase Created',
            'A new phase "' . $phase->name . '" has been created for project "' . $this->project->title . '".',
            'View Project',
            route('projects.show', $this->project->id),
            'info'
        );
        
        session()->flash('message', 'Phase created successfully.');
        $this->toggleForm();
        $this->emit('phaseCreated');
    }

    public function render()
    {
        return view('livewire.project.create');
    }
}

