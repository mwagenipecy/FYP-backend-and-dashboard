<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberOnBoardingController extends Controller
{


    public function onboardingOverView(){

        return view('backend.pages.onboarding.overview');
    }
}
