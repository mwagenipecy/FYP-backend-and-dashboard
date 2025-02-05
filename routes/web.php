<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test',function(){
 return view('demo');
});


Route::get('home',function(){
    return view('frontend.welcome');
   })->name("home_page");

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});




// front end

//********************** HUB LIST  */
Route::get("hub-page", function(){
 return view ("frontend.hub_page");
})->name('hub_page');



/********  VIEW BLOG PAGE */
Route::get('view-blog',function(){
    return view('frontend.view_blog');
})->name("view-blog");
