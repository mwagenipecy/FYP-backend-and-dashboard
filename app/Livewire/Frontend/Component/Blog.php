<?php

namespace App\Livewire\Frontend\Component;

use App\Models\Hub;
use Livewire\Component;

class Blog extends Component
{

    public $hub;
    public $hubId;

    public function mount($hubId=null){
 
        if($hubId==null){

            $this->hub=Hub::get();

        }else{

            $this->hubId=$hubId;
            $this->hub=Hub::find($hubId);
            if(!$this->hub){
                return redirect()->back()->with('error','Hub not found');
            }
        }
      
    }

    public function render()
    {
        return view('livewire.frontend.component.blog');
    }
}
