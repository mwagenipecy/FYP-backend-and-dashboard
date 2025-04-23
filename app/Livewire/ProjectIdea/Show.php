<?php

namespace App\Livewire\ProjectIdea;

use App\Models\Feedback;
use App\Models\Hub;
use App\Models\IdeaFeedBack;
use App\Models\User;
use App\Models\UserHasProject;
use Livewire\Component;
use App\Models\Project;
use App\Models\ProjectIdea;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
class Show extends Component
{

    public ProjectIdea $projectIdea;
    public $feedback;
    public $showFeedbackForm = false;
    public $qualificationRequest;
    public $showQualificationForm = false;

    public $showForm=null;

    public $showModal = false;
    public $projectDescription;

    public $approvalModal=false;
    public $hub_id, $supervisor_id;
    public $hubs = [], $supervisors = [];


    public $feedBackList=[];
    public $replies=[];

    public $title;

    public $description;

    public $idea_type;

    protected $rules = [
        'feedback' => 'required|min:10',
        'qualificationRequest' => 'required|min:10',
    ];

    public function mount(ProjectIdea $projectIdea)
    {
        $this->projectIdea = $projectIdea;
        $this->feedBackList=IdeaFeedBack::where('idea_id',$this->projectIdea->id)->get();
   
        $this->replies= Feedback::where('table','projectIdeaFeedBack')->where('idea_id',$this->projectIdea->id)->get();


        $this->title=  $this->projectIdea->title;
        $this->description =$this->projectIdea->description;
        $this->idea_type= $this->projectIdea->idea_type;


        //populate data

        $this->supervisors=User::where('role_id',10)->get();
       $this->hubs=Hub::where('status','active')->get();

    }


    public function approvalModalFuncion(){

        $this->approvalModal=!$this->approvalModal;

    }


    public function updateProjectIdea(){

       
     $this->validate([
        'title'=>'required|string',
        'description'=>'required|string',
        'idea_type'=>'required'
     ]);


     $this->projectIdea->update([
        'title'=>$this->title,
        'description'=>$this->description,
        'idea_type'=>$this->idea_type
     ]);




    }

    public function toggleModal()
    {
        $this->showModal = !$this->showModal;
    }

    public function showFeedback()
    {
        $this->showFeedbackForm = true;
        $this->showQualificationForm = false;
    }

    public function showQualification()
    {
        $this->showQualificationForm = true;
        $this->showFeedbackForm = false;
    }


    public function render()
    {
        return view('livewire.project-idea.show');
    }

    public $link,$comment;

    public function rejectIdea(){


        $this->validate(
            ['comment'=>'required|string',
            'link'=>'nullable|string'
            
            ]
        );



        $idea =  $this->projectIdea ;

    // Update status to rejected
    $idea->update([
        'status' => 'rejected'
    ]);

    // feedback message
     IdeaFeedBack::create([
       'comment'=>$this->comment,
       'link'=>$this->link,
       'user_id'=>auth()->user()->id,
       'type'=>'reject',
       'idea_id'=>  $this->projectIdea->id

     ]);



    // Record in activity log
    $idea->user->activities()->create([
        'name' => 'Project Idea Rejected',
        'description' => 'Your project idea "' . $idea->title . '" was rejected.',
        'type' => 'project_idea',
        'issue_date' => now(),
    ]);

    // Notify the owner
    NotificationService::sendToUser(
        $idea->user,
        'Project Idea Rejected',
        'Your project idea "' . $idea->title . '" has been rejected.',
        'View Details',
        route('project-ideas.show', $idea->id),
        'error'
    );

    session()->flash('message', 'Project idea rejected successfully.');

    }




    public function  requestQualification(){

        $this->validate(
            ['qualificationRequest'=>'required|string',
            'link'=>'nullable|string'
            
            ]
        );

    $idea =  $this->projectIdea ;
    // Update status to rejected
    $idea->update([
        'status' => 'needs_qualification'
    ]);

    // feedback message
     IdeaFeedBack::create([
       'comment'=>$this->qualificationRequest,
       'link'=>$this->link,
       'user_id'=>auth()->user()->id,
       'type'=>'needs_qualification',
       'idea_id'=>  $this->projectIdea->id

     ]);



    // Record in activity log
    $idea->user->activities()->create([
        'name' => 'Project Idea needs qualification',
        'description' => 'Your project idea "' . $idea->title . '" needs qualification.',
        'type' => 'project_idea',
        'issue_date' => now(),
    ]);

    // Notify the owner
    NotificationService::sendToUser(
        $idea->user,
        'Project Idea needs more qualification',
        'Your project idea "' . $idea->title . '" review and needs more qualification.',
        'View Details',
        route('project-ideas.show', $idea->id),
        'successfully'
    );

    session()->flash('message', 'request has been sent successfully.');

    }


    public function createUserFeedback($id){

        $this->validate([
            'comment'=>'required'
        ]);

        $idea =  $this->projectIdea ;
       
    
        // feedback message
         Feedback::create([
           'comment'=>$this->comment,
          'identifier'=>$id,
           'user_id'=>auth()->user()->id,
           'idea_id'=>  $this->projectIdea->id,
           'table'=>'projectIdeaFeedBack'
    
         ]);
    

    
    
        // Record in activity log
        $idea->user->activities()->create([
            'name' => auth()->user()->name. 'repied on  comment',
            'description' => 'Your project idea "' . $idea->title . '" needs qualification.',
            'type' => 'project_idea',
            'issue_date' => now(),
        ]);
    
        // Notify the owner
        NotificationService::sendToUser(
            auth()->user(),
            'Project Idea needs more qualification',
            'Your are taged on  project idea "' . $idea->title . '"  .',
            'View Details',
            route('project-ideas.show', $idea->id),
            'successfully'
        );
    
        session()->flash('message', 'request has been sent successfully.');

    }


    public function showFormFunction($id){

        if($id==$this->showForm){

            $this->showForm=null;
        }else{

            $this->showForm=$id;
        }

    }


    public function toggleReviewStatus(){


    $idea =  $this->projectIdea ;
    // Update status to rejected
    $idea->update([
        'status' => 'under_review'
    ]);

    



    // Record in activity log
    $idea->user->activities()->create([
        'name' => 'Project Idea is under_review ',
        'description' => 'Your project idea "' . $idea->title . '" is under review',
        'type' => 'project_idea',
        'issue_date' => now(),
    ]);

    // Notify the owner
    NotificationService::sendToUser(
        $idea->user,
        'Project Idea is under review',
        'Your project idea "' . $idea->title . '" is under review',
        'View Details',
        route('project-ideas.show', $idea->id),
        'successfully'
    );

    session()->flash('message', ' successfully.');
    }

    public function approveIdea(){




        $idea =  $this->projectIdea ;
    // Update status to rejected
    $idea->update([
        'status' => 'approved'
    ]);

    // create project message
   $project=  Project::create([
       'title'=> $this->projectIdea->title ,
       'description'=> $this->projectIdea->description ,
       'stage'=>'initial',
       'hub_id'=>$this->hub_id,
     ]);


     // assign project user
     $this->assignMembers($this->projectIdea->user_id,$project);

     // you can add also supervisor here 
     $this->assignSupervisor($this->supervisor_id?? auth()->user()->id,$project);

    // Record in activity log
    $idea->user->activities()->create([
        'name' => 'Project Idea now approved to be project',
        'description' => 'Your project idea "' . $idea->title . '" has approved .',
        'type' => 'project_idea',
        'issue_date' => now(),
    ]);

    // Notify the owner
    NotificationService::sendToUser(
        $idea->user,
        'Project Idea now has approved as project ',
        'Your project idea "' . $idea->title . '" approved.',
        'View Details',
        route('project-ideas.show', $idea->id),
        'successfully'
    );

    session()->flash('message', 'approved successfully.');
    $this->approvalModal=false;

    }



    public function assignMembers($memberId,$project)
    {
          
            $project->users()->attach($memberId, ['role' => 'member']);
            
            // Notify the assigned member
            $member = User::find($memberId);
            NotificationService::sendToUser(
                $member,
                'Project Member Assignment',
                'You have been assigned as a member for the project "' . $project->title . '".',
                'View Project',
                route('projects.show', $project->id),
                'info'
            );
            
            // Record in activity log
            $member->activities()->create([
                'name' => 'Member Assigned',
                'description' => 'Assigned as member to project: ' . $project->title,
                'type' => 'project',
                'project_id' => $project->id,
                'issue_date' => now(),
            ]);
        
        session()->flash('message', 'Project members updated successfully.');
    }





    public function assignSupervisor($supervisorId,  $project)
    {
        // Remove any existing supervisors
        $project->users()->wherePivot('role', 'supervisor')->detach();
        
        // Assign new supervisor
        $project->users()->attach($supervisorId, ['role' => 'supervisor']);
        
        
        // Notify the assigned supervisor
        $supervisor = User::find($supervisorId);
        NotificationService::sendToUser(
            $supervisor,
            'Project Supervisor Assignment',
            'You have been assigned as a supervisor for the project "' . $project->title . '".',
            'View Project',
            route('projects.show', $project->id),
            'info'
        );
        
        // Record in activity log
        $supervisor->activities()->create([
            'name' => 'Supervisor Assigned',
            'description' => 'Assigned as supervisor to project: ' . $project->title,
            'type' => 'project',
            'project_id' => $project->id,
            'issue_date' => now(),
        ]);
        
        session()->flash('message', 'Supervisor assigned successfully.');
    }



}
