<?php

namespace App\Http\Controllers\Backend\Page;

use App\Http\Controllers\Controller;
use App\Models\Hub;
use Illuminate\Http\Request;

class HubListController extends Controller
{

 public function index(){

    $hubs= Hub::get();

    return view("backend.pages.hubs.hubList",compact("hubs"));
 }


 public function viewSettings(){

   return view('backend.pages.hubs.setting');

 }
}
