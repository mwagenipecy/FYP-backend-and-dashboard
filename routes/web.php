<?php

use App\Http\Controllers\Backend\Page\HubListController;
use App\Http\Controllers\HubManagementController;
use App\Http\Controllers\IndividualProjectController;
use App\Http\Controllers\MemberOnBoardingController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectIdeaController;
use App\Http\Controllers\ProjectStageController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileManagementController;
use App\Http\Controllers\InvitationController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('test',function(){
 return view('demo');
});


Route::get('home',function(){
    return view('frontend.welcome');
   })->name("home_page");


   Route::get('/',function(){
    return view('frontend.welcome');
   });



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    ])->group(function () {
   
    Route::get('/user-dashboard', function () {
       return view('dashboard'); 

    })->name('dashboard');



    Route::get('/dashboard', function () {
        return redirect()->to('user-dashboard');
 
     });




    /******* HUB LIST */
    Route::group(['prefix'=> 'hub'], function () {  
      
        Route::get('/list',[HubListController::class,'index'] )->name('hub_list');
        Route::get('settings',[HubListController::class,'viewSettings'])->name('hub.settings');


    });


    /********************************* STAFF MANAGEMENT  ******************************/
    Route::group(['prefix'=>'staff'], function(){
        Route::get('list',[StaffController::class,'overView'])->name('staff.list');
    });



    /*******************************************MEMBER ONBOARDING PROCESS ********************/
    Route::group(['prefix'=>'onboarding'],function(){

        Route::get('member',[MemberOnBoardingController::class,'onboardingOverView'])->name('onboarding.member');

    });




    /************************************ GENERAL SYSTEM USERS **************************/

    Route::group(['prefix'=>'user'],function(){

        Route::get('list',[UserController::class,'userList'])->name('user.list');

        
    });



       /************************************ PROJECT MANAGEMENT **************************/

       Route::group(['prefix'=>'project'],function(){

        Route::get('list',[ProjectController::class,'index'])->name('project.list');
        Route::get('show/{id}',[ProjectController::class,'show'])->name('projects.show');

        
    });




    //*********************************** individual Project  */
    Route::group(['prefix'=>'individual-project'],function(){

        Route::get('dashboard/{id}',[IndividualProjectController::class,'overview'])->name('individual.project.list');

        // document management 
        Route::group(['prefix'=>'documents'],function(){
        Route::get('list',[IndividualProjectController::class,'viewDocument'])->name('document.list');
        Route::get('/upload',[IndividualProjectController::class,'uploadDocument'])->name('documents.upload');
        Route::get('/view/{id}',[IndividualProjectController::class,'viewIndividualDocument'])->name('documents.view');
        });



        Route::get('phase/{id}',[IndividualProjectController::class,'showProjectPhase'])->name('project.phases');

        Route::get('members/{id}',[IndividualProjectController::class,'projectUser'])->name('project.users');
     });





       /************************************ STAGES MANAGEMENT **************************/

       Route::group(['prefix'=>'stage'],function(){

        Route::get('list',[ProjectStageController::class,'index'])->name('stage.list');
        Route::get('show/{id}',[ProjectStageController::class,'show'])->name('stages.show');

        
    });




         /************************************ PROJECT IDEA MANAGEMENT **************************/

         Route::group(['prefix'=>'idea'],function(){

            Route::get('list',[ProjectIdeaController::class,'index'])->name('idea.list');
            Route::get('show/{id}',[ProjectIdeaController::class,'show'])->name('project-ideas.show');
    
            
        });



    




});





   /****************************************  INVITATION PAGE  *********************************************/
        Route::get('/invitations/{token}', [InvitationController::class, 'show'])->name('invitations.show');
        Route::post('/invitations/{token}/accept', [InvitationController::class, 'accept'])->middleware(['auth'])->name('invitations.accept');
        Route::post('/invitations/{token}/decline', [InvitationController::class, 'decline'])->middleware(['auth'])->name('invitations.decline');
        Route::post('/invitations/{token}/register', [InvitationController::class, 'registerAndAccept'])->name('invitations.register');




  /************************************** DOCUMENT MANAGEMENT ************************/
     // DOCUMENTS ROUTES
     Route::get('/file-management', [FileManagementController::class, 'index'])->name('file.management');

     Route::get('/document/preview', [FileManagementController::class, 'previewDocument'])
         ->name('document.preview')
         ->middleware(['signed']);




// Route::get('/dashboard', function () {
//     dd('yes reach');
// })->name('dashboard');



Route::get('demo123',function(){

  return view('welcome');
})->name('project-ideas.create');



Route::get('demo12343',function(){

    return view('welcome');
  })->name('project-ideas.showxx');




// front end





/********  VIEW BLOG PAGE */
Route::get('view-blog',function(){
    return view('frontend.view_blog');
})->name("view-blog");



/************** PROFILE VIEW */

Route::get('view-profile',function(){
    return view("frontend.profile_list");
});




/****************************************** PROJECT FRONTEND URLs */
Route::prefix('frontend')->group(function(){
 

    /***************************** HUB LIST URL *********************/
  //  Route::get('hubs',[HubManagementController::class,'hubList'])->name('hubs.list');
        Route::get("hub-page/{id}", [HubManagementController::class,'viewHub'])->name('hub_page');


});






// testing apis

Route::get('test12',function(){

    return view('dex');
});