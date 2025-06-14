<?php

namespace App\Livewire\Backend\Components\Hub;

use App\Models\Hub;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectIdea;
use App\Models\Document;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class HubListTable extends Component
{
    use WithPagination, WithFileUploads;
    
    // Search and filter properties
    public $search = '';
    public $statusFilter = '';
    public $supervisorFilter = '';
    public $performanceFilter = 'all';
    public $showActions = [];
    
    // Sorting
    public $sortField = 'name';
    public $sortDirection = 'asc';
    
    // Modal states
    public $showModal = false;
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $showAnalyticsModal = false;
    
    // Form properties
    public $hubId;
    public $name = '';
    public $email = '';
    public $phone_number = '';
    public $address = '';
    public $supervisor_id = '';
    public $status = 'active';
    public $image;
    public $existingImage = '';
    
    // Other properties
    public $selectedHub = null;
    public $isEditing = false;
    public $hubToDelete = null;
    
    // Overview data properties
    public $totalHubs = 0;
    public $activeHubs = 0;
    public $totalProjects = 0;
    public $totalIdeas = 0;
    public $pendingIdeas = 0;
    public $newHubsThisMonth = 0;
    
    // Validation rules
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('hubs', 'email')->ignore($this->hubId)
            ],
            'phone_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('hubs', 'phone_number')->ignore($this->hubId)
            ],
            'address' => 'nullable|string|max:500',
            'supervisor_id' => 'nullable|exists:users,id',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    // Custom validation messages
    protected $messages = [
        'name.required' => 'Hub name is required.',
        'email.required' => 'Email address is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already registered to another hub.',
        'phone_number.required' => 'Phone number is required.',
        'phone_number.unique' => 'This phone number is already registered to another hub.',
        'supervisor_id.exists' => 'Selected supervisor is invalid.',
        'status.required' => 'Status is required.',
        'status.in' => 'Status must be either active or inactive.',
        'image.image' => 'File must be an image.',
        'image.mimes' => 'Image must be jpeg, png, jpg, or gif format.',
        'image.max' => 'Image size cannot exceed 2MB.'
    ];
    
    // Listeners for events
    protected $listeners = [
        'refreshTable' => '$refresh'
    ];

    public function mount()
    {
        $this->loadOverviewData();
    }

    // Load overview statistics
    private function loadOverviewData()
    {
        $this->totalHubs = Hub::count();
        $this->activeHubs = Hub::where('status', 'active')->count();
        $this->totalProjects = Project::count();
        $this->totalIdeas = ProjectIdea::count();
        $this->pendingIdeas = ProjectIdea::where('status', 'submitted')->count();
        $this->newHubsThisMonth = Hub::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
    }

    // Refresh data
    public function refreshData()
    {
        $this->loadOverviewData();
        session()->flash('message', 'Data refreshed successfully.');
    }

    // Reset pagination when filters change
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function updatedStatusFilter()
    {
        $this->resetPage();
    }
    
    public function updatedSupervisorFilter()
    {
        $this->resetPage();
    }

    public function updatedPerformanceFilter()
    {
        $this->resetPage();
    }
    
    // Sort columns
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    // Toggle actions menu
    public function toggleActions($hubId)
    {
        if (isset($this->showActions[$hubId])) {
            unset($this->showActions[$hubId]);
        } else {
            // Close all other action menus first
            $this->showActions = [];
            $this->showActions[$hubId] = true;
        }
    }
    
    // Show add modal
    public function showAddModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }
    
    // View Hub Details
    public function viewHub($hubId)
    {
        $this->selectedHub = Hub::with('supervisor')->find($hubId);
        $this->showActions = []; // Close action menu
        $this->showViewModal = true;
    }

    // View Hub Analytics - THIS IS THE MISSING METHOD
    public function viewHubAnalytics($hubId)
    {
        $hub = Hub::with('supervisor')->find($hubId);
        if ($hub) {
            // Add performance metrics to the hub
            $hub->projects_count = Project::where('hub_id', $hubId)->count();
            $hub->ideas_count = ProjectIdea::whereHas('projects', function($query) use ($hubId) {
                $query->where('hub_id', $hubId);
            })->count();
            $hub->documents_count = Document::where('hub_id', $hubId)->count();
            
            $this->selectedHub = $hub;
            $this->showAnalyticsModal = true;
            $this->showActions = []; // Close action menu
        }
    }

    // Close analytics modal
    public function closeAnalyticsModal()
    {
        $this->showAnalyticsModal = false;
        $this->selectedHub = null;
    }

    // Manage Projects
    public function manageProjects($hubId)
    {
        // Redirect to projects management page for this hub
        session()->flash('message', 'Redirecting to project management...');
        // You can implement redirect logic here
        $this->showActions = [];
    }
    
    // Close view modal
    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->selectedHub = null;
    }
    
    // Edit hub
    public function editHub($hubId)
    {
        $hub = Hub::findOrFail($hubId);
        
        $this->hubId = $hub->id;
        $this->name = $hub->name;
        $this->email = $hub->email;
        $this->phone_number = $hub->phone_number;
        $this->address = $hub->address;
        $this->supervisor_id = $hub->supervisor_id;
        $this->status = $hub->status;
        $this->existingImage = $hub->image;
        
        $this->isEditing = true;
        $this->showModal = true;
        $this->showViewModal = false;
        $this->showAnalyticsModal = false;
        $this->showActions = []; // Close action menu
    }
    
    // Close modal
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->resetValidation();
    }
    
    // Reset form fields
    private function resetForm()
    {
        $this->hubId = null;
        $this->name = '';
        $this->email = '';
        $this->phone_number = '';
        $this->address = '';
        $this->supervisor_id = '';
        $this->status = 'active';
        $this->image = null;
        $this->existingImage = '';
        $this->isEditing = false;
    }
    
    // Save hub (create or update)
    public function saveHub()
    {
        $this->validate();
        
        try {
            $hubData = [
                'name' => $this->name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'address' => $this->address,
                'supervisor_id' => $this->supervisor_id ?: null,
                'status' => $this->status,
            ];
            
            // Handle image upload
            if ($this->image) {
                // Delete old image if editing
                if ($this->isEditing && $this->existingImage) {
                    Storage::disk('public')->delete($this->existingImage);
                }
                
                $imagePath = $this->image->store('hubs', 'public');
                $hubData['image'] = $imagePath;
            }
            
            if ($this->isEditing) {
                // Update existing hub
                $hub = Hub::findOrFail($this->hubId);
                $hub->update($hubData);
                
                session()->flash('message', "Hub '{$this->name}' was updated successfully.");
            } else {
                // Create new hub
                Hub::create($hubData);
                
                session()->flash('message', "Hub '{$this->name}' was created successfully.");
            }
            
            $this->closeModal();
            $this->loadOverviewData(); // Refresh overview data
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save hub: ' . $e->getMessage());
        }
    }
    
    // Confirm delete action
    public function confirmDelete($hubId)
    {
        $this->hubToDelete = $hubId;
        $this->showDeleteModal = true;
        $this->showActions = []; // Close action menu
    }
    
    // Close delete modal
    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->hubToDelete = null;
    }
    
    // Delete hub after confirmation
    public function deleteHub()
    {
        try {
            $hub = Hub::findOrFail($this->hubToDelete);
            $hubName = $hub->name;
            
            // Delete associated image
            if ($hub->image) {
                Storage::disk('public')->delete($hub->image);
            }
            
            // Delete the hub
            $hub->delete();
            
            // Flash success message
            session()->flash('message', "Hub '$hubName' was deleted successfully.");
            
            // Close modal and clear selections
            $this->closeDeleteModal();
            $this->showActions = [];
            $this->loadOverviewData(); // Refresh overview data
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete hub: ' . $e->getMessage());
            $this->closeDeleteModal();
        }
    }

    // Export data functionality
    public function exportData()
    {
        try {
            // Implement CSV export logic here
            session()->flash('message', 'Data export initiated. Download will start shortly.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to export data: ' . $e->getMessage());
        }
    }

    // Generate report functionality
    public function generateReport()
    {
        try {
            // Implement report generation logic here
            session()->flash('message', 'Report generation initiated. It will be available for download shortly.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to generate report: ' . $e->getMessage());
        }
    }
    
    // Real-time validation
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    public function render()
    {
        // Get supervisors for the filter dropdown
        $supervisors = User::whereHas('supervisedHubs')
            ->orderBy('name')
            ->get();
        
        // Build query with filters
        $hubsQuery = Hub::query()
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone_number', 'like', '%' . $this->search . '%')
                      ->orWhere('address', 'like', '%' . $this->search . '%')
                      ->orWhereHas('supervisor', function ($sq) {
                          $sq->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->statusFilter, function ($query) {
                return $query->where('status', $this->statusFilter);
            })
            ->when($this->supervisorFilter, function ($query) {
                return $query->where('supervisor_id', $this->supervisorFilter);
            })
            ->with('supervisor') // Eager load supervisor relationship
            ->orderBy($this->sortField, $this->sortDirection);

        // Get hubs with pagination
        $hubs = $hubsQuery->paginate(10);

        // Add performance metrics to each hub
        $hubs->getCollection()->transform(function ($hub) {
            $hub->projects_count = Project::where('hub_id', $hub->id)->count();
            $hub->ideas_count = ProjectIdea::whereHas('projects', function($query) use ($hub) {
                $query->where('hub_id', $hub->id);
            })->count();
            $hub->documents_count = Document::where('hub_id', $hub->id)->count();
            return $hub;
        });

        // Apply performance filter after adding metrics
        if ($this->performanceFilter !== 'all') {
            $filteredHubs = $hubs->getCollection()->filter(function ($hub) {
                switch ($this->performanceFilter) {
                    case 'top_performers':
                        return $hub->projects_count > 0;
                    case 'needs_attention':
                        return $hub->projects_count == 0 && $hub->status == 'active';
                    default:
                        return true;
                }
            });
            $hubs->setCollection($filteredHubs);
        }
            
        return view('livewire.backend.components.hub.hub-list-table', [
            'hubs' => $hubs,
            'supervisors' => $supervisors,
            'totalHubs' => $this->totalHubs,
            'activeHubs' => $this->activeHubs,
            'totalProjects' => $this->totalProjects,
            'totalIdeas' => $this->totalIdeas,
            'pendingIdeas' => $this->pendingIdeas,
            'newHubsThisMonth' => $this->newHubsThisMonth
        ]);
    }
}