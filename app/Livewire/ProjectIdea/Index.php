<?php

namespace App\Livewire\ProjectIdea;

use App\Models\ProjectIdea;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];



    

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();
        $query = ProjectIdea::query();
        
        // If user is not admin/reviewer, show only their ideas
        if (!$user->role->name == 'Admin' && !$user->role->name == 'Reviewer') {
            $query->where('user_id', $user->id);
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
        
        $projectIdeas = $query->latest()->paginate(10);
        
        return view('livewire.project-idea.index', [
            'projectIdeas' => $projectIdeas,
            'metrics'=> [
                'ideaMonthlyTrend' => $this->loadChartData()
            ],
        ]);
    }


    public function loadChartData(){

        $monthlyIdeas = Projectidea::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy('month')
        ->pluck('total', 'month');

    // Fill in missing months with 0
    $ideaCounts = [];
    for ($i = 1; $i <= 12; $i++) {
        $ideaCounts[] = $monthlyIdeas->get($i, 0);
    }



    return $ideaCounts;
    }
}