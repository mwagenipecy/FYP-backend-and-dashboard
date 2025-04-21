<?php

namespace App\Http\Controllers;

use App\Models\ProjectIdea;
use Illuminate\Http\Request;

class ProjectIdeaController extends Controller
{
    public function index(){

        return view('backend.pages.idea.list');
    }


    public function show($id){

        $projectIdea=ProjectIdea::find($id);

        return view('backend.pages.idea.show',compact('projectIdea'));
    }
}
