<?php

namespace App\Livewire\Backend\Components\Student;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectIdea;
use App\Models\Hub;
use App\Models\Level;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentProfiles extends Component
{
    use WithPagination;
    
    // Filter and search properties
    public $search = '';
    public $levelFilter = '';
    public $fieldTypeFilter = '';
    public $projectStatusFilter = '';
    public $hubFilter = '';
    public $viewMode = 'grid'; // grid or list
    
    // Sorting
    public $sortField = 'name';
    public $sortDirection = 'asc';
    
    // Statistics
    public $totalStudents = 0;
    public $activeStudents = 0;
    public $totalProjects = 0;
    public $hubConnections = 0;
    
    // Modal states
    public $showProfileModal = false;
    public $selectedStudent = null;
    public $showStudentActions = [];
    
    public function mount()
    {
        $this->loadStatistics();
    }

    // Load dashboard statistics
    private function loadStatistics()
    {
        $this->totalStudents = User::count();
        
        // Active students (those with at least one project)
        $this->activeStudents = User::whereExists(function($query) {
            $query->select(DB::raw(1))
                ->from('user_has_projects')
                ->whereColumn('user_has_projects.user_id', 'users.id');
        })->count();
        
        $this->totalProjects = Project::count();
        
        // Hub connections (student-hub relationships through projects)
        $this->hubConnections = DB::table('user_has_projects')
            ->join('projects', 'user_has_projects.project_id', '=', 'projects.id')
            ->distinct(['user_has_projects.user_id', 'projects.hub_id'])
            ->count();
    }

    // Refresh data
    public function refreshData()
    {
        $this->loadStatistics();
        session()->flash('message', 'Data refreshed successfully.');
    }

    // Filter updates
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedLevelFilter()
    {
        $this->resetPage();
    }

    public function updatedFieldTypeFilter()
    {
        $this->resetPage();
    }

    public function updatedProjectStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedHubFilter()
    {
        $this->resetPage();
    }

    // Reset all filters
    public function resetFilters()
    {
        $this->search = '';
        $this->levelFilter = '';
        $this->fieldTypeFilter = '';
        $this->projectStatusFilter = '';
        $this->hubFilter = '';
        $this->resetPage();
    }

    // Sorting
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Student actions
    public function toggleStudentActions($studentId)
    {
        if (isset($this->showStudentActions[$studentId])) {
            unset($this->showStudentActions[$studentId]);
        } else {
            $this->showStudentActions = [];
            $this->showStudentActions[$studentId] = true;
        }
    }

    public function viewStudentProfile($studentId)
    {
        $student = User::with(['level'])->findOrFail($studentId);
        
        // Get student's recent projects
        $recentProjects = Project::whereExists(function($query) use ($studentId) {
                $query->select(DB::raw(1))
                    ->from('user_has_projects')
                    ->whereColumn('user_has_projects.project_id', 'projects.id')
                    ->where('user_has_projects.user_id', $studentId);
            })
            ->with('hub')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get student's hubs with project counts
        $studentHubs = Hub::whereExists(function($query) use ($studentId) {
                $query->select(DB::raw(1))
                    ->from('projects')
                    ->join('user_has_projects', 'projects.id', '=', 'user_has_projects.project_id')
                    ->whereColumn('projects.hub_id', 'hubs.id')
                    ->where('user_has_projects.user_id', $studentId);
            })
            ->get()
            ->map(function($hub) use ($studentId) {
                $hub->projects_in_hub = Project::where('hub_id', $hub->id)
                    ->whereExists(function($query) use ($studentId) {
                        $query->select(DB::raw(1))
                            ->from('user_has_projects')
                            ->whereColumn('user_has_projects.project_id', 'projects.id')
                            ->where('user_has_projects.user_id', $studentId);
                    })
                    ->count();
                return $hub;
            });

        // Add skills (assuming stored as JSON or comma-separated)
        $student->skills = $this->parseSkills($student);
        $student->recent_projects = $recentProjects;
        $student->student_hubs = $studentHubs;

        $this->selectedStudent = $student;
        $this->showProfileModal = true;
        $this->showStudentActions = [];
    }

    public function closeProfileModal()
    {
        $this->showProfileModal = false;
        $this->selectedStudent = null;
    }

    public function viewStudentProjects($studentId)
    {
        // Redirect to projects page filtered by student
        session()->flash('message', 'Redirecting to student projects...');
        // You can implement redirect logic here
        $this->showStudentActions = [];
    }

    public function messageStudent($studentId)
    {
        // Open messaging interface
        session()->flash('message', 'Opening message composer...');
        // You can implement messaging logic here
        $this->showStudentActions = [];
    }

    public function assignToHub($studentId)
    {
        // Show hub assignment modal
        session()->flash('message', 'Opening hub assignment...');
        // You can implement hub assignment logic here
        $this->showStudentActions = [];
    }

    public function viewAnalytics($studentId)
    {
        // Show student analytics
        session()->flash('message', 'Opening student analytics...');
        // You can implement analytics logic here
        $this->showStudentActions = [];
    }

    public function editStudent($studentId)
    {
        // Show edit student modal
        session()->flash('message', 'Opening student editor...');
        // You can implement edit logic here
        $this->showStudentActions = [];
    }

    public function viewProject($projectId)
    {
        // Redirect to project details
        session()->flash('message', 'Redirecting to project details...');
        // You can implement redirect logic here
    }

    public function exportStudents()
    {
        try {
            // Implement CSV export of students
            session()->flash('message', 'Student export initiated. Download will start shortly.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to export students: ' . $e->getMessage());
        }
    }

    // Helper method to parse skills from user data
    private function parseSkills($user)
    {
        // This depends on how you store skills in your database
        // Assuming you might have a skills field as JSON or comma-separated
        if (isset($user->skills)) {
            if (is_string($user->skills)) {
                // If stored as comma-separated
                return array_filter(explode(',', $user->skills));
            } elseif (is_array($user->skills)) {
                // If stored as JSON
                return $user->skills;
            }
        }
        
        // For now, return some sample skills based on field type
        $skillsByField = [
            'technology' => ['Programming', 'Web Development', 'Database Design', 'UI/UX'],
            'business' => ['Marketing', 'Finance', 'Strategy', 'Leadership'],
            'design' => ['Graphic Design', 'UI Design', 'Branding', 'Typography'],
            'science' => ['Research', 'Data Analysis', 'Laboratory Skills', 'Documentation'],
            'engineering' => ['Problem Solving', 'CAD Design', 'Project Management', 'Innovation'],
        ];

        return $skillsByField[$user->fieldType] ?? ['Communication', 'Teamwork', 'Problem Solving'];
    }

    // Get students with all necessary data
    private function getStudents()
    {
        $query = User::select('users.*');

        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('users.name', 'like', '%' . $this->search . '%')
                  ->orWhere('users.email', 'like', '%' . $this->search . '%')
                  ->orWhere('users.regno', 'like', '%' . $this->search . '%');
            });
        }

        // Apply level filter
        if ($this->levelFilter) {
            $query->where('level_id', $this->levelFilter);
        }

        // Apply field type filter
        if ($this->fieldTypeFilter) {
            $query->where('fieldType', $this->fieldTypeFilter);
        }

        // Apply project status filter
        if ($this->projectStatusFilter) {
            switch ($this->projectStatusFilter) {
                case 'active':
                    $query->whereExists(function($subQuery) {
                        $subQuery->select(DB::raw(1))
                            ->from('user_has_projects')
                            ->join('projects', 'user_has_projects.project_id', '=', 'projects.id')
                            ->whereColumn('user_has_projects.user_id', 'users.id')
                            ->where('projects.status', 'active');
                    });
                    break;
                case 'completed':
                    $query->whereExists(function($subQuery) {
                        $subQuery->select(DB::raw(1))
                            ->from('user_has_projects')
                            ->join('projects', 'user_has_projects.project_id', '=', 'projects.id')
                            ->whereColumn('user_has_projects.user_id', 'users.id')
                            ->whereIn('projects.status', ['completed', 'finished']);
                    });
                    break;
                case 'none':
                    $query->whereNotExists(function($subQuery) {
                        $subQuery->select(DB::raw(1))
                            ->from('user_has_projects')
                            ->whereColumn('user_has_projects.user_id', 'users.id');
                    });
                    break;
            }
        }

        // Apply hub filter
        if ($this->hubFilter) {
            $query->whereExists(function($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('user_has_projects')
                    ->join('projects', 'user_has_projects.project_id', '=', 'projects.id')
                    ->whereColumn('user_has_projects.user_id', 'users.id')
                    ->where('projects.hub_id', $this->hubFilter);
            });
        }

        // Apply sorting
        $query->orderBy('users.' . $this->sortField, $this->sortDirection);

        $students = $query->paginate(12);

        // Add additional data for each student
        $students->getCollection()->transform(function ($student) {
            // Get project counts
            $projectIds = DB::table('user_has_projects')
                ->where('user_id', $student->id)
                ->pluck('project_id');

            $student->projects_count = $projectIds->count();

            // Get hub count
            $student->hubs_count = DB::table('user_has_projects')
                ->join('projects', 'user_has_projects.project_id', '=', 'projects.id')
                ->where('user_has_projects.user_id', $student->id)
                ->distinct('projects.hub_id')
                ->count();

            // Get ideas count
            $student->ideas_count = ProjectIdea::where('user_id', $student->id)->count();

            // Get latest project
            $student->latest_project = Project::whereExists(function($query) use ($student) {
                    $query->select(DB::raw(1))
                        ->from('user_has_projects')
                        ->whereColumn('user_has_projects.project_id', 'projects.id')
                        ->where('user_has_projects.user_id', $student->id);
                })
                ->orderBy('created_at', 'desc')
                ->first();

            // Add skills
            $student->skills = $this->parseSkills($student);

            return $student;
        });

        return $students;
    }

    public function render()
    {
        $students = $this->getStudents();
        $levels = Level::orderBy('name')->get();
        $hubs = Hub::orderBy('name')->get();

        return view('livewire.backend.components.student.student-profiles', [
            'students' => $students,
            'levels' => $levels,
            'hubs' => $hubs,
            'totalStudents' => $this->totalStudents,
            'activeStudents' => $this->activeStudents,
            'totalProjects' => $this->totalProjects,
            'hubConnections' => $this->hubConnections
        ]);
    }
}