<?php

namespace App\Livewire\PhaseManage;

use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\Stage;
use App\Models\StageSubmission;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class PhaseManagement extends Component
{
    use WithFileUploads;

    public Project $project;
    public $phases = [];
    public $currentPhase = null;
    public $currentStage = null;
    public $submission = '';
    public $feedback = '';
    public $editingPhase = null;
    public $editingStage = null;
    public $phaseForm = [
        'name' => '',
        'description' => '',
        'order' => 1,
    ];
    public $stageForm = [
        'name' => '',
        'description' => '',
        'order' => 1,
        'phase_id' => null,
    ];
    public $documents = [];
    public $newDocument = null;
    public $documentTitle = '';
    public $documentDescription = '';

    protected $rules = [
        'submission' => 'required|string',
        'feedback' => 'required|string',
        'phaseForm.name' => 'required|string|max:45',
        'phaseForm.description' => 'nullable|string',
        'phaseForm.order' => 'required|integer|min:1',
        'stageForm.name' => 'required|string|max:45',
        'stageForm.description' => 'nullable|string',
        'stageForm.order' => 'required|integer|min:1',
        'stageForm.phase_id' => 'required|exists:project_phases,id',
        'documentTitle' => 'required|string|max:255',
        'documentDescription' => 'nullable|string',
        'newDocument' => 'nullable|file|max:10240', // 10MB max
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->loadPhases();
    }

    public function loadPhases()
    {
        // Load phases with stages
        $this->phases = ProjectPhase::where('project_id', $this->project->id)
            ->with(['stages' => function ($query) {
                $query->orderBy('order');
            }])
            ->orderBy('order')
            ->get()
            ->toArray();
            
        // Set default current phase and stage if not set
        if (!$this->currentPhase && count($this->phases) > 0) {
            $this->setCurrentPhase($this->phases[0]['id']);
        }
    }

    public function setCurrentPhase($phaseId)
    {
        $this->currentPhase = ProjectPhase::with(['stages' => function ($query) {
            $query->orderBy('order');
        }])->findOrFail($phaseId);
        
        // Set current stage to first stage in phase if available
        if (count($this->currentPhase->stages) > 0) {
            $this->setCurrentStage($this->currentPhase->stages[0]->id);
        } else {
            $this->currentStage = null;
        }
    }

    public function setCurrentStage($stageId)
    {
        $this->currentStage = Stage::findOrFail($stageId);
        $this->submission = '';
        $this->feedback = '';
        
        // Load latest submission if exists
        $latestSubmission = StageSubmission::where('stage_id', $stageId)
            ->where('user_id', Auth::id())
            ->latest()
            ->first();
            
        if ($latestSubmission) {
            $this->submission = $latestSubmission->content;
        }
        
        // Load documents for this stage
        $this->documents = $this->currentStage->documents()->get();
    }

    // Add new phase
    public function showAddPhase()
    {
        $this->resetPhaseForm();
        $this->editingPhase = 'new';
        
        // Set default order to next in sequence
        $this->phaseForm['order'] = count($this->phases) + 1;
    }
    
    public function cancelPhaseEdit()
    {
        $this->editingPhase = null;
        $this->resetPhaseForm();
    }
    
    public function savePhase()
    {
        $this->validate([
            'phaseForm.name' => 'required|string|max:45',
            'phaseForm.description' => 'nullable|string',
            'phaseForm.order' => 'required|integer|min:1',
        ]);
        
        if ($this->editingPhase === 'new') {
            // Create new phase
            ProjectPhase::create([
                'name' => $this->phaseForm['name'],
                'description' => $this->phaseForm['description'],
                'order' => $this->phaseForm['order'],
                'project_id' => $this->project->id,
            ]);
            
            session()->flash('message', 'Phase added successfully.');
        } else {
            // Update existing phase
            $phase = ProjectPhase::findOrFail($this->editingPhase);
            $phase->update([
                'name' => $this->phaseForm['name'],
                'description' => $this->phaseForm['description'],
                'order' => $this->phaseForm['order'],
            ]);
            
            session()->flash('message', 'Phase updated successfully.');
        }
        
        $this->editingPhase = null;
        $this->resetPhaseForm();
        $this->loadPhases();
    }
    
    public function editPhase($phaseId)
    {
        $phase = ProjectPhase::findOrFail($phaseId);
        $this->phaseForm = [
            'name' => $phase->name,
            'description' => $phase->description,
            'order' => $phase->order,
        ];
        $this->editingPhase = $phaseId;
    }
    
    public function deletePhase($phaseId)
    {
        // Check if the user has permission to delete
        if (!$this->canManageProject()) {
            session()->flash('error', 'You do not have permission to delete phases.');
            return;
        }
        
        $phase = ProjectPhase::findOrFail($phaseId);
        
        // Check if phase has stages with submissions
        $stagesWithSubmissions = $phase->stages()->whereHas('submissions')->exists();
        
        if ($stagesWithSubmissions) {
            session()->flash('error', 'Cannot delete phase because it has stages with submissions.');
            return;
        }
        
        // Delete the phase and reorder remaining phases
        $phase->delete();
        $this->reorderPhases();
        
        session()->flash('message', 'Phase deleted successfully.');
        $this->loadPhases();
        
        // Reset current phase if deleted
        if ($this->currentPhase && $this->currentPhase->id == $phaseId) {
            if (count($this->phases) > 0) {
                $this->setCurrentPhase($this->phases[0]['id']);
            } else {
                $this->currentPhase = null;
                $this->currentStage = null;
            }
        }
    }
    
    // Add new stage
    public function showAddStage($phaseId)
    {
        $this->resetStageForm();
        $this->editingStage = 'new';
        $this->stageForm['phase_id'] = $phaseId;
        
        // Set default order to next in sequence
        $phase = ProjectPhase::findOrFail($phaseId);
        $this->stageForm['order'] = $phase->stages()->count() + 1;
    }
    
    public function cancelStageEdit()
    {
        $this->editingStage = null;
        $this->resetStageForm();
    }
    
    public function saveStage()
    {
        $this->validate([
            'stageForm.name' => 'required|string|max:45',
            'stageForm.description' => 'nullable|string',
            'stageForm.order' => 'required|integer|min:1',
            'stageForm.phase_id' => 'required|exists:project_phases,id',
        ]);
        
        if ($this->editingStage === 'new') {
            // Create new stage
            Stage::create([
                'name' => $this->stageForm['name'],
                'description' => $this->stageForm['description'],
                'order' => $this->stageForm['order'],
                'phase_id' => $this->stageForm['phase_id'],
                'project_id' => $this->project->id,
                'status' => 'pending'
            ]);
            
            session()->flash('message', 'Stage added successfully.');
        } else {
            // Update existing stage
            $stage = Stage::findOrFail($this->editingStage);
            $stage->update([
                'name' => $this->stageForm['name'],
                'description' => $this->stageForm['description'],
                'order' => $this->stageForm['order'],
                'phase_id' => $this->stageForm['phase_id'],
            ]);
            
            session()->flash('message', 'Stage updated successfully.');
        }
        
        $this->editingStage = null;
        $this->resetStageForm();
        $this->loadPhases();
        
        // Refresh current phase if needed
        if ($this->currentPhase) {
            $this->setCurrentPhase($this->currentPhase->id);
        }
    }
    
    public function editStage($stageId)
    {
        $stage = Stage::findOrFail($stageId);
        $this->stageForm = [
            'name' => $stage->name,
            'description' => $stage->description,
            'order' => $stage->order,
            'phase_id' => $stage->phase_id,
        ];
        $this->editingStage = $stageId;
    }
    
    public function deleteStage($stageId)
    {
        // Check if the user has permission to delete
        if (!$this->canManageProject()) {
            session()->flash('error', 'You do not have permission to delete stages.');
            return;
        }
        
        $stage = Stage::findOrFail($stageId);
        
        // Check if stage has submissions
        if ($stage->submissions()->exists()) {
            session()->flash('error', 'Cannot delete stage because it has submissions.');
            return;
        }
        
        // Store phase_id before deletion
        $phaseId = $stage->phase_id;
        
        // Delete the stage and reorder remaining stages
        $stage->delete();
        $this->reorderStages($phaseId);
        
        session()->flash('message', 'Stage deleted successfully.');
        $this->loadPhases();
        
        // Reset current stage if deleted
        if ($this->currentStage && $this->currentStage->id == $stageId) {
            if ($this->currentPhase && $this->currentPhase->stages->count() > 0) {
                $this->setCurrentStage($this->currentPhase->stages[0]->id);
            } else {
                $this->currentStage = null;
            }
        }
    }
    
    // Submit work for a stage
    public function submitWork()
    {
        $this->validate([
            'submission' => 'required|string',
        ]);
        
        // Check if stage is already approved
        if ($this->currentStage->status === 'approved') {
            session()->flash('error', 'This stage has already been approved and cannot receive new submissions.');
            return;
        }
        
        // Create submission
        $submission = StageSubmission::create([
            'stage_id' => $this->currentStage->id,
            'user_id' => Auth::id(),
            'content' => $this->submission,
            'status' => 'submitted'
        ]);
        
        // Update stage status
        $this->currentStage->update([
            'status' => 'in_review'
        ]);
        
        // Notify project supervisor
        $supervisor = $this->project->supervisor()->first();
        if ($supervisor) {
            NotificationService::sendToUser(
                $supervisor,
                'New Stage Submission',
                'A new submission has been made for stage "' . $this->currentStage->name . '" in project "' . $this->project->title . '".',
                'Review Submission',
                route('projects.list', ['project' => $this->project->id, 'tab' => 'phases']),
                'info'
            );
        }
        
        session()->flash('message', 'Work submitted successfully.');
        $this->loadPhases();
        $this->setCurrentStage($this->currentStage->id); // Refresh stage data
    }
    
    // Provide feedback and approve/reject a stage submission
    public function provideFeedback($action)
    {
        // Check if user is supervisor
        if (!$this->isProjectSupervisor()) {
            session()->flash('error', 'Only project supervisors can provide feedback and approve/reject submissions.');
            return;
        }
        
        $this->validate([
            'feedback' => 'required|string',
        ]);
        
        // Get latest submission
        $submission = StageSubmission::where('stage_id', $this->currentStage->id)
            ->latest()
            ->first();
            
        if (!$submission) {
            session()->flash('error', 'No submission found for this stage.');
            return;
        }
        
        // Update submission with feedback
        $submission->update([
            'feedback' => $this->feedback,
            'status' => $action // 'approved' or 'rejected'
        ]);
        
        // If approved, update stage status
        if ($action === 'approved') {
            $this->currentStage->update([
                'status' => 'approved'
            ]);
            
            // Check if all stages in phase are approved
            $allStagesApproved = !$this->currentPhase->stages()
                ->where('status', '!=', 'approved')
                ->exists();
                
            if ($allStagesApproved) {
                // Mark the phase as complete in some way (maybe in the UI)
                // You could add a status column to phases if needed
            }
        } else {
            // If rejected, update stage status back to pending
            $this->currentStage->update([
                'status' => 'pending'
            ]);
        }
        
        // Notify the submitter
        $submitter = User::find($submission->user_id);
        NotificationService::sendToUser(
            $submitter,
            'Submission ' . ucfirst($action),
            'Your submission for stage "' . $this->currentStage->name . '" has been ' . $action . '.',
            'View Feedback',
            route('projects.show', ['project' => $this->project->id, 'tab' => 'phases']),
            $action === 'approved' ? 'success' : 'warning'
        );
        
        session()->flash('message', 'Feedback provided and submission ' . $action . '.');
        $this->feedback = '';
        $this->loadPhases();
        $this->setCurrentStage($this->currentStage->id); // Refresh stage data
    }
    
    // Upload document for a stage
    public function uploadDocument()
    {
        $this->validate([
            'newDocument' => 'required|file|max:10240', // 10MB max
            'documentTitle' => 'required|string|max:255',
            'documentDescription' => 'nullable|string',
        ]);
        
        $path = $this->newDocument->store('documents', 'public');
        
        // Create document record
        $document = $this->currentStage->documents()->create([
            'title' => $this->documentTitle,
            'description' => $this->documentDescription,
            'file_path' => $path,
            'file_name' => $this->newDocument->getClientOriginalName(),
            'file_type' => $this->newDocument->getClientOriginalExtension(),
            'file_size' => $this->newDocument->getSize(),
            'hub_id' => $this->project->hub_id,
            'uploaded_by' => Auth::id(),
            'is_approved' => false,
        ]);
        
        // Reset form fields
        $this->reset(['newDocument', 'documentTitle', 'documentDescription']);
        
        // Refresh documents list
        $this->documents = $this->currentStage->documents()->get();
        
        session()->flash('message', 'Document uploaded successfully.');
    }
    
    // Approve document
    public function approveDocument($documentId)
    {
        // Check if user is supervisor
        // if (!$this->isProjectSupervisor()) {
        //     session()->flash('error', 'Only project supervisors can approve documents.');
        //     return;
        // }

        /// TODO
        
        $document = $this->currentStage->documents()->findOrFail($documentId);
        
        $document->update([
            'is_approved' => true,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        
        // Notify the uploader
        $uploader = User::find($document->uploaded_by);
        NotificationService::sendToUser(
            $uploader,
            'Document Approved',
            'Your document "' . $document->title . '" has been approved.',
            'View Document',
            route('projects.show', $this->project->id),
            'success'
        );
        
        session()->flash('message', 'Document approved successfully.');
        
        // Refresh documents list
        $this->documents = $this->currentStage->documents()->get();
    }
    
    // Helper functions
    private function resetPhaseForm()
    {
        $this->phaseForm = [
            'name' => '',
            'description' => '',
            'order' => 1,
        ];
    }
    
    private function resetStageForm()
    {
        $this->stageForm = [
            'name' => '',
            'description' => '',
            'order' => 1,
            'phase_id' => null,
        ];
    }
    
    private function reorderPhases()
    {
        $phases = ProjectPhase::where('project_id', $this->project->id)
            ->orderBy('order')
            ->get();
            
        foreach ($phases as $index => $phase) {
            $phase->update(['order' => $index + 1]);
        }
    }
    
    private function reorderStages($phaseId)
    {
        $stages = Stage::where('phase_id', $phaseId)
            ->orderBy('order')
            ->get();
            
        foreach ($stages as $index => $stage) {
            $stage->update(['order' => $index + 1]);
        }
    }
    
    private function isProjectSupervisor()
    {
        $user = Auth::user();
        return $this->project->users()
           // ->wherePivot('role', 'supervisor')
            ->where('users.id', $user->id)
            ->exists();
    }
    
    private function canManageProject()
    {
        $user = Auth::user();
        
        // Check if user is a supervisor or admin
        if ($this->isProjectSupervisor()) {
            return true;
        }
        
        // Check if user has Admin role
        return $user->role && $user->role->name === 'Admin';
    }
    
    public function render()
    {
        $latestSubmission = null;
        $userIsProjectMember = false;
        $userIsProjectSupervisor =  true ;//$this->isProjectSupervisor(); ///TODO
        
        if ($this->currentStage) {
            $latestSubmission = StageSubmission::where('stage_id', $this->currentStage->id)
                ->latest()
                ->first();
                
            // Check if current user is a project member
            $userIsProjectMember = $this->project->users()
                ->wherePivot('role', 'member')
                ->where('users.id', Auth::id())
                ->exists();
        }
        
        return view('livewire.phase-manage.phase-management', [
            'project' => $this->project,
            'latestSubmission' => $latestSubmission,
            'userIsProjectMember' => $userIsProjectMember,
            'userIsProjectSupervisor' => $userIsProjectSupervisor,
        ]);
    }
}
