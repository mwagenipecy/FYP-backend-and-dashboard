<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogManagementController extends Controller
{
    public function blogList(){

        return view('backend.pages.blog.blog-list');
    }
}
