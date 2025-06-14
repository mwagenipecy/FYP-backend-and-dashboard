<?php

namespace App\Http\Controllers\Backend\Page;

use App\Http\Controllers\Controller;
use App\Models\Hub;
use App\Models\Project;
use Illuminate\Http\Request;

class HubListController extends Controller
{

 public function index(){

    $hubs= Hub::get();

    $totalHubs=Hub::count();
    $activeHubs=Hub::where('status','active')->count();
    $totalProject=Project::count();

    return view("backend.pages.hubs.hubList",
    ["hubs"=>$hubs,
    "totalHubs"=>$totalHubs,
    "activeHubs"=>$activeHubs,
    "totalProject"=>$totalProject
      ]);
 }


 public function viewSettings(){

   return view('backend.pages.hubs.setting');
   
 }


 public function viewHubSummary($id){


    return view('backend.pages.hubs.hubSummary',
    [
        'hubId'=>$id,
        
    ]);
 }



}
