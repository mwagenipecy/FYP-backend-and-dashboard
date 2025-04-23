<?php

namespace App\Livewire\ProjectIdea;

use App\Models\Idea;
use App\Models\ProjectIdea;
use Livewire\Component;

class IdeaMetrix extends Component
{

    public $metrics;

    public $totalIdea,$pendingIdea, $acceptedIdea;


    public function mount(){
        $this->loadData();
    }


    public function loadData(){

        
        $this->totalIdea=ProjectIdea::count();

        $this->pendingIdea=ProjectIdea::whereNotIn('status',['rejected','approved'])->count();

    }

    public function render()
    {
        return view('livewire.project-idea.idea-metrix');
    }
}
