<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function overView(){

        return view ('backend.pages.staffs.staff-overview');
    }
}
