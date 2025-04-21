<?php

namespace App\Livewire\Frontend\Component;

use App\Models\Idea;
use App\Models\Project;
use App\Models\User;
use Livewire\Component;

class NumberSummary extends Component
{

    public $totalProjects=0;

    public $totalIdeas=0;

    public $successfullyProject=0;

    public $totalStudents=0;


    public function mount(){

        $this->totalProjects=Project::count();
        $this->totalIdeas=Idea::count();
        $this->successfullyProject=Project::where('status','completed')->count();

        $this->totalStudents=User::count();
    }

    public function render()
    {
        return view('livewire.frontend.component.number-summary');
    }
}
