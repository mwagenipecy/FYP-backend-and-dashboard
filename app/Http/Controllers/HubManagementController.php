<?php

namespace App\Http\Controllers;

use App\Models\Hub;
use Illuminate\Http\Request;

class HubManagementController extends Controller
{
    public function viewHub($id){


        $hub=Hub::find($id);
        if(!$hub){
            return redirect()->back()->with('error','Hub not found');
        }

        return view ("frontend.hub_page",[
            'hub'=>$hub,
        ]);
    }


    public function applicationWindow(){

        return view("frontend.hub-application-window");
    }
}
