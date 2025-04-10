<?php

namespace App\Livewire\Backend\Components\Hub;

use App\Models\Hub;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class HubListTable extends Component
{
    use WithPagination;
    
    // Search and filter properties
    public $search = '';
    public $statusFilter = '';
    public $supervisorFilter = '';
    public $showActions = [];
    
    // Sorting
    public $sortField = 'name';
    public $sortDirection = 'asc';
    
    // For selection
    public $selectedHub = null;
    
    // Listeners for events
    protected $listeners = [
        'refreshTable' => '$refresh'
    ];

    public function boot()
    {
        // Register event listener for delete hub event
        $this->dispatch('registerListener', ['deleteHub' => 'deleteHub']);
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
    
    // View Hub Details - if needed
    public function viewHub($hubId)
    {
        $this->selectedHub = Hub::find($hubId);
    }
    
    // Confirm delete action
    public function confirmDelete($hubId)
    {
        // Dispatch browser event to show modal
        $this->dispatch('show-delete-modal', ['hubId' => $hubId]);
    }
    
    // Delete hub after confirmation
    public function deleteHub($hubId)
    {
        try {
            $hub = Hub::findOrFail($hubId);
            $hubName = $hub->name;
            
            // Delete the hub
            $hub->delete();
            
            // Flash success message
            session()->flash('message', "Hub '$hubName' was deleted successfully.");
            
            // Clear any selected actions
            $this->showActions = [];
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete hub: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        // Get supervisors for the filter dropdown
        $supervisors = User::whereHas('supervisedHubs')->get();
        
        // Build query with filters
        $hubs = Hub::query()
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone_number', 'like', '%' . $this->search . '%')
                      ->orWhere('address', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                return $query->where('status', $this->statusFilter);
            })
            ->when($this->supervisorFilter, function ($query) {
                return $query->where('supervisor_id', $this->supervisorFilter);
            })
            ->with('supervisor') // Eager load supervisor relationship
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
            
        return view('livewire.backend.components.hub.hub-list-table', [
            'hubs' => $hubs,
            'supervisors' => $supervisors
        ]);
    }
}