<?php

namespace App\Livewire\Backend\Onboarding;

use Livewire\Component;
use App\Models\User;
use App\Models\Invitation;
use App\Models\OnboardingQuestion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\MemberInvitation;

class OverView extends Component
{



    use WithPagination;
    
    // Sidebar modals control
    public $showInvitationSidebar = false;
    public $showRegisterSidebar = false;
    public $showQuestionsSidebar = false;
    
    // Form data
    public $invitationEmail = '';
    public $invitationMessage = '';
    
    // New user registration
    public $name, $email, $regno, $password, $password_confirmation, $role_id = 3, $level_id = 1;
    
    // Onboarding questions
    public $questions = [];
    public $newQuestion = '';
    public $newQuestionRequired = false;
    
    // Stats period
    public $statsPeriod = 'month'; // month, quarter, year
    
    protected $rules = [
        'invitationEmail' => 'required|email',
        'invitationMessage' => 'nullable|string|max:500',
        
        // Registration rules
        'name' => 'required|string|min:3',
        'email' => 'required|email|unique:users,email',
        'regno' => 'nullable|string|unique:users,regno',
        'password' => 'required|min:8|confirmed',
        'role_id' => 'required|exists:roles,id',
        'level_id' => 'required|exists:levels,id',
        
        // Question rules
        'newQuestion' => 'required|string|min:5',
        'newQuestionRequired' => 'boolean',
    ];
    
    public function mount()
    {
        $this->loadExistingQuestions();
    }
    
    public function loadExistingQuestions()
    {
        $this->questions = [];
    }
    
    public function toggleInvitationSidebar()
    {
        $this->reset(['invitationEmail', 'invitationMessage']);
        $this->showInvitationSidebar = !$this->showInvitationSidebar;
        
        if ($this->showInvitationSidebar) {
            $this->showRegisterSidebar = false;
            $this->showQuestionsSidebar = false;
        }
    }
    
    public function toggleRegisterSidebar()
    {
        $this->reset(['name', 'email', 'regno', 'password', 'password_confirmation']);
        $this->showRegisterSidebar = !$this->showRegisterSidebar;
        
        if ($this->showRegisterSidebar) {
            $this->showInvitationSidebar = false;
            $this->showQuestionsSidebar = false;
        }
    }
    
    public function toggleQuestionsSidebar()
    {
        $this->reset(['newQuestion', 'newQuestionRequired']);
        $this->showQuestionsSidebar = !$this->showQuestionsSidebar;
        
        if ($this->showQuestionsSidebar) {
            $this->showInvitationSidebar = false;
            $this->showRegisterSidebar = false;
        }
    }
    
    public function sendInvitation()
    {
        $this->validate([
            'invitationEmail' => 'required|email',
            'invitationMessage' => 'nullable|string|max:500',
        ]);
        
        // Generate a unique token
        $token = Str::random(32);
        
        // Create invitation record
        $invitation = Invitation::create([
            'email' => $this->invitationEmail,
            'token' => $token,
            'message' => $this->invitationMessage,
            'expires_at' => Carbon::now()->addDays(7),
        ]);
        
        // Send email with invitation link
        Mail::to($this->invitationEmail)->send(new MemberInvitation($invitation));
        
        // Reset form and close sidebar
        $this->reset(['invitationEmail', 'invitationMessage']);
        $this->showInvitationSidebar = false;
        
        session()->flash('message', 'Invitation sent successfully to ' . $invitation->email);
    }
    
    public function registerMember()
    {
        $this->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'regno' => 'nullable|string|unique:users,regno',
            'password' => 'required|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'level_id' => 'required|exists:levels,id',
        ]);
        
        // Create user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'regno' => $this->regno,
            'password' => bcrypt($this->password),
            'role_id' => $this->role_id,
            'level_id' => $this->level_id,
            'status' => 'pending', // New members start as pending
        ]);
        
        // Reset form and close sidebar
        $this->reset(['name', 'email', 'regno', 'password', 'password_confirmation']);
        $this->showRegisterSidebar = false;
        
        session()->flash('message', 'New member registered successfully: ' . $user->name);
    }
    
    public function addQuestion()
    {
        $this->validate([
            'newQuestion' => 'required|string|min:5',
            'newQuestionRequired' => 'boolean',
        ]);
        
        // Create new onboarding question
        $question = OnboardingQuestion::create([
            'question' => $this->newQuestion,
            'is_required' => $this->newQuestionRequired,
            'order' => count($this->questions) + 1,
        ]);
        
        // Reset form
        $this->reset(['newQuestion', 'newQuestionRequired']);
        
        // Reload questions
        $this->loadExistingQuestions();
        
        session()->flash('message', 'Onboarding question added successfully.');
    }
    
    public function deleteQuestion($id)
    {
        OnboardingQuestion::find($id)->delete();
        
        // Reload questions
        $this->loadExistingQuestions();
        
        session()->flash('message', 'Question removed successfully.');
    }
    
    public function setStatsPeriod($period)
    {
        $this->statsPeriod = $period;
    }
    
    public function getOnboardingStatsProperty()
    {
        // Determine date period based on selected option
        switch ($this->statsPeriod) {
            case 'quarter':
                $startDate = Carbon::now()->subMonths(3);
                $groupFormat = 'W'; // Week number
                $labelFormat = 'Week ';
                break;
            case 'year':
                $startDate = Carbon::now()->subYear();
                $groupFormat = 'M'; // Month abbreviation
                $labelFormat = '';
                break;
            default: // month
                $startDate = Carbon::now()->subMonth();
                $groupFormat = 'd'; // Day of month
                $labelFormat = 'Day ';
                break;
        }
        
        // Get onboarding data
        $onboardingData = User::where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE_FORMAT(created_at, "%' . $groupFormat . '") as period'), 
                     DB::raw('count(*) as count'))
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->map(function ($item) use ($labelFormat) {
                return [
                    'period' => $labelFormat . $item->period,
                    'count' => $item->count
                ];
            });
        
        return $onboardingData;
    }
    
    public function getRecentInvitationsProperty()
    {
        return [];
    }
    
    public function getPendingMembersProperty()
    {
        return User::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }
    
    public function render()
    {
        return view('livewire.backend.onboarding.over-view', [
            'onboardingStats' => $this->onboardingStats,
            'recentInvitations' => $this->recentInvitations,
            'pendingMembers' => $this->pendingMembers,
            'roles' => \App\Models\Role::all(),
            'levels' => \App\Models\Level::all(),
        ]);
    }



  
}
