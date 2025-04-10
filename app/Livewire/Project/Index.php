<?php

namespace App\Livewire\Project;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $hubFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'hubFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingHubFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();
        $query = Project::query();
        
        // If user is not admin, show only their associated projects
        if (!$user->role || $user->role->name != 'Admin') {
            $query->whereHas('users', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }
        
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }
        
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }
        
        if ($this->hubFilter) {
            $query->where('hub_id', $this->hubFilter);
        }
        
        $projects = $query->latest()->paginate(10);
        $hubs = \App\Models\Hub::all();
        
        return view('livewire.project.index', [
            'projects' => $projects,
            'hubs' => $hubs,
        ]);
    }
}