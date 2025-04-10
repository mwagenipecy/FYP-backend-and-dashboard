<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use Illuminate\Http\Request;

class ProjectStageController extends Controller
{
    public function show($id){

        $stage= Stage::find($id);
        if (!$stage) {
            return redirect()->back()->with('error', 'Stage not found.');
        }   
        return view('backend.pages.stage.show', compact('stage'));
    }
}
