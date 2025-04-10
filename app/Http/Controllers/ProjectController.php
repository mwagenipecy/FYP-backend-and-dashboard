<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    

    public function index(){

        return view('backend.pages.project.list');
    }

    public function show($id){

         $project=Project::find($id);
        if (!$project) {
            return redirect()->back()->with('error', 'Project not found');
        }


        return view('backend.pages.project.show', compact('project'));
    }
}
