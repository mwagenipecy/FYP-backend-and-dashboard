<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class IndividualProjectController extends Controller
{
    public function overview($id){

           session()->put('projectId',$id);
           $project=Project::find($id);
           session()->put('project',$project);
        return view('backend.pages.individualProject.dashboard');
    }
}
