<?php

use App\Http\Controllers\Backend\Page\HubListController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('test',function(){
 return view('demo');
});


Route::get('home',function(){
    return view('frontend.welcome');
   })->name("home_page");

Route::middleware([
   // 'auth:sanctum',
    config('jetstream.auth_session')])->group(function () {
   
    Route::get('/', function () {
       return view('/dashboard'); 
    })->name('dashboard');




    /******* HUB LIST */
    Route::group(['prefix'=> 'hub'], function () {  

        Route::get('/list',[HubListController::class,'index'] )->name('hub_list');

    });



});



// Route::get('/dashboard', function () {
//     dd('yes reach');
// })->name('dashboard');



Route::get('demo123',function(){

  return view('welcome');
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



/************** PROFILE VIEW */

Route::get('view-profile',function(){
    return view("frontend.profile_list");
});
