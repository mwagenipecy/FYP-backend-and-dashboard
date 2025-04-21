<?php

namespace App\Livewire\Frontend\Component;

use App\Models\Hub;
use Livewire\Component;

class Welcome extends Component
{

    public $hubList=[];


    public function mount(){

        $this->hubList=Hub::where('status','active')->get();
    }
    public function render()
    {
        return view('livewire.frontend.component.welcome');
    }
}
