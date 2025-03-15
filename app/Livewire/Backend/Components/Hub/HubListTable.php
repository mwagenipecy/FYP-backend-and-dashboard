<?php

namespace App\Livewire\Backend\Components\Hub;

use App\Models\Hub;
use Livewire\Component;

class HubListTable extends Component
{

    // public function mount($hubs)
    // {
    //     $this->hubs = $hubs;
    // }
    public function render()
    {
        $hubs=Hub::get();
        return view('livewire.backend.components.hub.hub-list-table',compact("hubs"));
    }
}
