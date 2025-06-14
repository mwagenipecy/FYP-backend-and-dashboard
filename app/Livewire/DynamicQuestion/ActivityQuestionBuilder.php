<?php

namespace App\Livewire\DynamicQuestion;

use App\Models\Activity;
use App\Models\DynamicQuestion;
use App\Models\ActivityQuestion;
use App\Models\Hub;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;


use App\Models\QuestionAnswer;
use App\Models\ActivityParticipant;
use App\Models\User;


class ActivityQuestionBuilder extends Component
{
    use WithPagination;

    // Main view states
    public $currentView = 'activities'; // activities, questions, responses, individual_response
    public $selectedActivity = null;
    public $selectedParticipant = null;
    
    // Activity management
    public $selectedHub = 'all';
    public $selectedStatus = 'all';
    public $searchActivity = '';
    
    // Response management
    public $selectedResponseStatus = 'all';
    public $searchParticipant = '';
    public $dateFrom = '';
    public $dateTo = '';
    
    // Individual response review
    public $reviewingParticipant = null;
    public $reviewNotes = '';
    public $reviewStatus = 'approved';
    public $showReviewModal = false;

    protected $queryString = [
        'currentView' => ['except' => 'activities'],
        'selectedActivity' => ['except' => null],
        'selectedHub' => ['except' => 'all'],
        'selectedStatus' => ['except' => 'all'],
    ];

    public function mount()
    {
        // Auto-select user's first hub if available
        if ($this->selectedHub === 'all') {
            $firstHub =Hub::find(1); // Auth::user()->managedHubs()->first();
            if ($firstHub) {
                $this->selectedHub = $firstHub->id;
            }
        }
    }

    // Navigation methods
    public function showActivities()
    {
        $this->currentView = 'activities';
        $this->selectedActivity = null;
        $this->selectedParticipant = null;
        $this->resetPage();
    }

    public function showActivityQuestions($activityId)
    {
        $this->selectedActivity = Activity::find($activityId);
        $this->currentView = 'questions';
        $this->resetPage();
    }

    public function showActivityResponses($activityId)
    {
        $this->selectedActivity = Activity::find($activityId);
        $this->currentView = 'responses';
        $this->resetPage();
    }

    public function showIndividualResponse($participantId)
    {
        $this->selectedParticipant = User::find($participantId);
        $this->currentView = 'individual_response';
    }

    public function backToResponses()
    {
        $this->currentView = 'responses';
        $this->selectedParticipant = null;
    }

    // Activity management methods
    public function toggleActivityStatus($activityId)
    {
        $activity = Activity::find($activityId);
        if ($activity && Auth::user()->canManageActivitiesIn($activity->hub)) {
            $activity->update(['is_active' => !$activity->is_active]);
            session()->flash('message', 'Activity status updated successfully!');
        }
    }

    public function duplicateActivity($activityId)
    {
        $activity = Activity::find($activityId);
        if ($activity && Auth::user()->canManageActivitiesIn($activity->hub)) {
            $newActivity = $activity->replicate();
            $newActivity->name = $activity->name . ' (Copy)';
            $newActivity->save();

            // Copy questions
            foreach ($activity->questions as $question) {
                $newQuestion = $question->replicate();
                $newQuestion->activity_id = $newActivity->id;
                $newQuestion->save();

                // Link to new activity
                $newActivity->questions()->attach($newQuestion->id, [
                    'display_order' => $question->pivot->display_order,
                    'is_required' => $question->pivot->is_required,
                ]);
            }

            session()->flash('message', 'Activity duplicated successfully!');
        }
    }

    // Response management methods
    public function startReview($participantId)
    {
        $this->reviewingParticipant = User::find($participantId);
        $this->reviewNotes = '';
        $this->reviewStatus = 'approved';
        $this->showReviewModal = true;
    }

    public function submitReview()
    {
        $this->validate([
            'reviewStatus' => 'required|in:approved,rejected',
            'reviewNotes' => 'nullable|string|max:1000',
        ]);

        // Update all responses for this participant in this activity
        QuestionAnswer::where('activity_id', $this->selectedActivity->id)
            ->where('user_id', $this->reviewingParticipant->id)
            ->update([
                'status' => $this->reviewStatus,
                'reviewer_id' => Auth::id(),
                'reviewed_at' => now(),
                'reviewer_notes' => $this->reviewNotes,
            ]);

        // Update participant status if it's a registration
        if ($this->selectedActivity->activity_type === 'registration') {
            ActivityParticipant::where('activity_id', $this->selectedActivity->id)
                ->where('user_id', $this->reviewingParticipant->id)
                ->update([
                    'status' => $this->reviewStatus,
                    'approved_by' => Auth::id(),
                    'approved_at' => now(),
                    'notes' => $this->reviewNotes,
                ]);
        }

        session()->flash('message', 'Participant responses reviewed successfully!');
        $this->cancelReview();
    }

    public function cancelReview()
    {
        $this->showReviewModal = false;
        $this->reviewingParticipant = null;
        $this->reviewNotes = '';
        $this->reviewStatus = 'approved';
    }

    public function exportActivityData($activityId)
    {
        // Implementation for exporting activity data
        session()->flash('message', 'Export functionality will be implemented here.');
    }

    // Data retrieval methods
    private function getActivities()
    {
        $query = Activity::with(['hub', 'questions', 'participants'])
            ->withCount(['participants as total_participants', 'responses as total_responses'])
            ->latest('created_at');

        // Apply filters
        if ($this->selectedHub !== 'all') {
            $query->where('hub_id', $this->selectedHub);
        }

        if ($this->selectedStatus !== 'all') {
            if ($this->selectedStatus === 'active') {
                $query->where('is_active', true);
            } else {
                $query->where('is_active', false);
            }
        }

        if ($this->searchActivity) {
            $query->where('name', 'like', '%' . $this->searchActivity . '%');
        }

        // Filter by user's accessible hubs
        $userHubIds = Auth::user()->getAccessibleHubIds();
        if (!empty($userHubIds)) {
            $query->whereIn('hub_id', $userHubIds);
        }

        return $query->paginate(10);
    }

    private function getActivityParticipants()
    {
        if (!$this->selectedActivity) {
            return collect();
        }

        $query = User::whereHas('activityResponses', function($q) {
                $q->where('activity_id', $this->selectedActivity->id);
            })
            ->with(['activityResponses' => function($q) {
                $q->where('activity_id', $this->selectedActivity->id)
                  ->with('question');
            }])
            ->withCount(['activityResponses as response_count' => function($q) {
                $q->where('activity_id', $this->selectedActivity->id);
            }]);

        // Apply filters
        if ($this->selectedResponseStatus !== 'all') {
            $query->whereHas('activityResponses', function($q) {
                $q->where('activity_id', $this->selectedActivity->id)
                  ->where('status', $this->selectedResponseStatus);
            });
        }

        if ($this->searchParticipant) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchParticipant . '%')
                  ->orWhere('email', 'like', '%' . $this->searchParticipant . '%');
            });
        }

        return $query->paginate(15);
    }

    private function getIndividualResponses()
    {
        if (!$this->selectedActivity || !$this->selectedParticipant) {
            return collect();
        }

        return QuestionAnswer::where('activity_id', $this->selectedActivity->id)
            ->where('user_id', $this->selectedParticipant->id)
            ->with(['question', 'reviewer'])
            ->orderBy('id')
            ->get();
    }

    private function getActivityStats()
    {
        if (!$this->selectedActivity) {
            return [];
        }

        $totalResponses = QuestionAnswer::where('activity_id', $this->selectedActivity->id)->count();
        $uniqueParticipants = QuestionAnswer::where('activity_id', $this->selectedActivity->id)
            ->distinct('user_id')->count('user_id');
        
        return [
            'total_questions' => $this->selectedActivity->questions()->count(),
            'total_responses' => $totalResponses,
            'unique_participants' => $uniqueParticipants,
            'pending_reviews' => QuestionAnswer::where('activity_id', $this->selectedActivity->id)
                ->where('status', 'submitted')->distinct('user_id')->count('user_id'),
            'approved_participants' => QuestionAnswer::where('activity_id', $this->selectedActivity->id)
                ->where('status', 'approved')->distinct('user_id')->count('user_id'),
            'rejected_participants' => QuestionAnswer::where('activity_id', $this->selectedActivity->id)
                ->where('status', 'rejected')->distinct('user_id')->count('user_id'),
        ];
    }

    private function getRegistrationStats()
    {
        if (!$this->selectedActivity || $this->selectedActivity->activity_type !== 'registration') {
            return [];
        }

        return [
            'total_registrations' => ActivityParticipant::where('activity_id', $this->selectedActivity->id)->count(),
            'pending_registrations' => ActivityParticipant::where('activity_id', $this->selectedActivity->id)
                ->where('status', 'pending')->count(),
            'approved_registrations' => ActivityParticipant::where('activity_id', $this->selectedActivity->id)
                ->where('status', 'approved')->count(),
            'rejected_registrations' => ActivityParticipant::where('activity_id', $this->selectedActivity->id)
                ->where('status', 'rejected')->count(),
            'available_slots' => $this->selectedActivity->max_participants 
                ? max(0, $this->selectedActivity->max_participants - ActivityParticipant::where('activity_id', $this->selectedActivity->id)->where('status', 'approved')->count())
                : 'Unlimited',
        ];
    }

    // Update methods for filters
    public function updatingSearchActivity()
    {
        $this->resetPage();
    }

    public function updatingSelectedHub()
    {
        $this->resetPage();
    }

    public function updatingSelectedStatus()
    {
        $this->resetPage();
    }

    public function updatingSearchParticipant()
    {
        $this->resetPage();
    }

    public function updatingSelectedResponseStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = [];

        // Get user's accessible hubs
        $userHubIds = Auth::user()->getAccessibleHubIds();
        $hubs = Hub::whereIn('id', $userHubIds)->where('status', 'active')->orderBy('name')->get();

        switch ($this->currentView) {
            case 'activities':
                $data['activities'] = $this->getActivities();
                break;
                
            case 'questions':
                $data['activity'] = $this->selectedActivity;
                $data['questions'] = $this->selectedActivity ? 
                    $this->selectedActivity->questions()->orderBy('activity_questions.display_order')->get() : 
                    collect();
                break;
                
            case 'responses':
                $data['activity'] = $this->selectedActivity;
                $data['participants'] = $this->getActivityParticipants();
                $data['stats'] = $this->getActivityStats();
                $data['registrationStats'] = $this->getRegistrationStats();
                break;
                
            case 'individual_response':
                $data['activity'] = $this->selectedActivity;
                $data['participant'] = $this->selectedParticipant;
                $data['responses'] = $this->getIndividualResponses();
                break;
        }

        $data['hubs'] = $hubs;
        $data['currentView'] = $this->currentView;

        return view('livewire.dynamic-question.activity-question-builder', $data);
    }
}
