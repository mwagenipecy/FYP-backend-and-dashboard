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


    public function viewDocument(){

        return view('backend.pages.individualProject.document');
    }


    public function uploadDocument(){

        return view('backend.pages.individualProject.upload-document');
    }

    public function viewIndividualDocument($id){

        return view('backend.pages.individualProject.view-document',['documentId'=>$id]);
    }



    public function showProjectPhase($id){

        $project=Project::find($id);

        return view('backend.pages.individualProject.project-phase',['project'=>$project]);
    }


    public function projectUser($id){
        $project=Project::find($id);

        return view('backend.pages.individualProject.project-user',['project'=>$project]);
    }
}
