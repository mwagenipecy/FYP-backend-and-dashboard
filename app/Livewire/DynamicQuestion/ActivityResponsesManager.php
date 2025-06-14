<?php

namespace App\Livewire\DynamicQuestion;

use App\Models\Activity;
use App\Models\QuestionAnswer;
use App\Models\DynamicQuestion;
use App\Models\ActivityParticipant;
use App\Models\Hub;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ActivityResponsesManager extends Component
{
    use WithPagination;

    public $selectedActivity = 'all';
    public $selectedHub = 'all';
    public $selectedStatus = 'all';
    public $searchEmail = '';
    public $searchName = '';
    public $dateFrom = '';
    public $dateTo = '';
    
    // Bulk actions
    public $selectedResponses = [];
    public $selectAll = false;
    
    // Response review
    public $reviewingResponseId = null;
    public $reviewNotes = '';
    public $reviewStatus = 'approved';

    protected $queryString = [
        'selectedActivity' => ['except' => 'all'],
        'selectedHub' => ['except' => 'all'],
        'selectedStatus' => ['except' => 'all'],
        'searchEmail' => ['except' => ''],
        'searchName' => ['except' => ''],
    ];

    public function updatingSearchEmail()
    {
        $this->resetPage();
    }

    public function updatingSearchName()
    {
        $this->resetPage();
    }

    public function updatingSelectedActivity()
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

    public function updatedSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedResponses = $this->getFilteredResponses()->pluck('id')->toArray();
        } else {
            $this->selectedResponses = [];
        }
    }

    public function toggleResponseSelection($responseId)
    {
        if (in_array($responseId, $this->selectedResponses)) {
            $this->selectedResponses = array_diff($this->selectedResponses, [$responseId]);
        } else {
            $this->selectedResponses[] = $responseId;
        }
        
        $this->selectAll = count($this->selectedResponses) === $this->getFilteredResponses()->count();
    }

    public function startReview($responseId)
    {
        $this->reviewingResponseId = $responseId;
        $this->reviewNotes = '';
        $this->reviewStatus = 'approved';
    }

    public function submitReview()
    {
        $this->validate([
            'reviewStatus' => 'required|in:approved,rejected',
            'reviewNotes' => 'nullable|string|max:1000',
        ]);

        $response = QuestionAnswer::find($this->reviewingResponseId);
        if ($response) {
            $response->update([
                'status' => $this->reviewStatus,
                'reviewer_id' => Auth::id(),
                'reviewed_at' => now(),
                'reviewer_notes' => $this->reviewNotes,
            ]);

            // If it's a registration, update participant status
            if ($response->activity && $response->activity->activity_type === 'registration') {
                ActivityParticipant::where('activity_id', $response->activity_id)
                    ->where('user_id', $response->user_id)
                    ->update([
                        'status' => $this->reviewStatus,
                        'approved_by' => Auth::id(),
                        'approved_at' => now(),
                        'notes' => $this->reviewNotes,
                    ]);
            }

            session()->flash('message', 'Response reviewed successfully!');
        }

        $this->cancelReview();
    }

    public function cancelReview()
    {
        $this->reviewingResponseId = null;
        $this->reviewNotes = '';
        $this->reviewStatus = 'approved';
    }

    public function bulkApprove()
    {
        if (empty($this->selectedResponses)) {
            session()->flash('error', 'Please select responses to approve.');
            return;
        }

        QuestionAnswer::whereIn('id', $this->selectedResponses)
            ->update([
                'status' => 'approved',
                'reviewer_id' => Auth::id(),
                'reviewed_at' => now(),
            ]);

        // Update participant status for registrations
        $responses = QuestionAnswer::whereIn('id', $this->selectedResponses)
            ->with('activity')
            ->get();

        foreach ($responses as $response) {
            if ($response->activity && $response->activity->activity_type === 'registration') {
                ActivityParticipant::where('activity_id', $response->activity_id)
                    ->where('user_id', $response->user_id)
                    ->update([
                        'status' => 'approved',
                        'approved_by' => Auth::id(),
                        'approved_at' => now(),
                    ]);
            }
        }

        session()->flash('message', count($this->selectedResponses) . ' responses approved successfully!');
        $this->selectedResponses = [];
        $this->selectAll = false;
    }

    public function bulkReject()
    {
        if (empty($this->selectedResponses)) {
            session()->flash('error', 'Please select responses to reject.');
            return;
        }

        QuestionAnswer::whereIn('id', $this->selectedResponses)
            ->update([
                'status' => 'rejected',
                'reviewer_id' => Auth::id(),
                'reviewed_at' => now(),
            ]);

        session()->flash('message', count($this->selectedResponses) . ' responses rejected successfully!');
        $this->selectedResponses = [];
        $this->selectAll = false;
    }

    public function exportResponses()
    {
        // Implementation for exporting responses to CSV/Excel
        $responses = $this->getFilteredResponses()->get();
        
        session()->flash('message', 'Export functionality will be implemented here.');
    }

    private function getFilteredResponses()
    {
        $query = QuestionAnswer::with(['question', 'activity', 'hub', 'user', 'reviewer'])
            ->latest('answered_at');

        // Apply filters
        if ($this->selectedActivity !== 'all') {
            $query->where('activity_id', $this->selectedActivity);
        }

        if ($this->selectedHub !== 'all') {
            $query->where('hub_id', $this->selectedHub);
        }

        if ($this->selectedStatus !== 'all') {
            $query->where('status', $this->selectedStatus);
        }

        if ($this->searchEmail) {
            $query->where('student_email', 'like', '%' . $this->searchEmail . '%');
        }

        if ($this->searchName) {
            $query->where('student_name', 'like', '%' . $this->searchName . '%');
        }

        if ($this->dateFrom) {
            $query->whereDate('answered_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('answered_at', '<=', $this->dateTo);
        }

        // Filter by user's accessible hubs
        $userHubIds = Auth::user()->getAccessibleHubIds();
        if (!empty($userHubIds)) {
            $query->whereIn('hub_id', $userHubIds);
        }

        return $query;
    }

    public function render()
    {
        $responses = $this->getFilteredResponses()->paginate(20);
        
        // Get activities and hubs for filters
        $userHubIds = Auth::user()->getAccessibleHubIds();
        
        $activities = Activity::when(!empty($userHubIds), function($query) use ($userHubIds) {
                return $query->whereIn('hub_id', $userHubIds);
            })
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $hubs = Hub::when(!empty($userHubIds), function($query) use ($userHubIds) {
                return $query->whereIn('id', $userHubIds);
            })
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // Statistics
        $stats = [
            'total' => $this->getFilteredResponses()->count(),
            'pending' => $this->getFilteredResponses()->where('status', 'submitted')->count(),
            'approved' => $this->getFilteredResponses()->where('status', 'approved')->count(),
            'rejected' => $this->getFilteredResponses()->where('status', 'rejected')->count(),
        ];

        return view('livewire.dynamic-question.activity-responses-manager', [
            'responses' => $responses,
            'activities' => $activities,
            'hubs' => $hubs,
            'stats' => $stats,
        ]);
    }
}