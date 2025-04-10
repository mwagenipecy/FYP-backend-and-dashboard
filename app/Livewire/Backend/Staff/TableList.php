<?php

namespace App\Livewire\Backend\Staff;

use App\Models\User;
use App\Models\Role;
use App\Models\Level;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class TableList extends Component
{


    use WithPagination;
    
    // Search and filter properties
    public $search = '';
    public $roleFilter = '';
    public $levelFilter = '';
    public $showActions = [];
    
    // Sorting
    public $sortField = 'name';
    public $sortDirection = 'asc';
    
    // Form properties
    public $showForm = false;
    public $formMode = 'create';
    public $userId = null;
    
    // Form fields
    public $name = '';
    public $email = '';
    public $regno = '';
    public $role_id = '';
    public $level_id = '';
    public $password = '';
    public $generatedPassword = '';
    
    // Validation rules
    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'regno' => 'nullable|string|max:50',
            'role_id' => 'required|exists:roles,id',
            'level_id' => 'required|exists:levels,id',
        ];
        
        // Add unique validation for email and regno, but exclude current user when editing
        if ($this->formMode === 'create') {
            $rules['email'] .= '|unique:users,email';
            $rules['regno'] .= '|unique:users,regno';
        } else {
            $rules['email'] .= '|unique:users,email,' . $this->userId;
            $rules['regno'] .= '|unique:users,regno,' . $this->userId;
        }
        
        return $rules;
    }
    
    // Reset pagination when filters change
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function updatedRoleFilter()
    {
        $this->resetPage();
    }
    
    public function updatedLevelFilter()
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
    public function toggleActions($userId)
    {
        if (isset($this->showActions[$userId])) {
            unset($this->showActions[$userId]);
        } else {
            // Close all other action menus first
            $this->showActions = [];
            $this->showActions[$userId] = true;
        }
    }
    
    // Show create form
    public function createStaff()
    {
        $this->resetForm();
        $this->generatePassword();
        $this->formMode = 'create';
        $this->showForm = true;
    }
    
    // Show edit form
    public function editStaff($userId)
    {
        $this->resetForm();
        $this->userId = $userId;
        $this->formMode = 'edit';
        
        $user = User::findOrFail($userId);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->regno = $user->regno;
        $this->role_id = $user->role_id;
        $this->level_id = $user->level_id;
        
        $this->showForm = true;
    }
    
    // Save staff member (create or update)
    public function saveStaff()
    {
        $this->validate();
        
        if ($this->formMode === 'create') {
            // Create new user
            $user = new User();
            $user->password = Hash::make($this->generatedPassword);
        } else {
            // Update existing user
            $user = User::findOrFail($this->userId);
        }
        
        $user->name = $this->name;
        $user->email = $this->email;
        $user->regno = $this->regno;
        $user->role_id = $this->role_id;
        $user->level_id = $this->level_id;
        
        $user->save();
        
        // Show success message
        if ($this->formMode === 'create') {
            session()->flash('message', 'Staff member created successfully. Password: ' . $this->generatedPassword);
        } else {
            session()->flash('message', 'Staff member updated successfully.');
        }
        
        $this->closeForm();
    }
    
    // Generate random password
    public function generatePassword()
    {
        $this->generatedPassword = Str::random(8);
    }
    
    // Confirm delete
    public function confirmDelete($userId)
    {
        $this->dispatch('show-delete-modal', ['userId' => $userId]);
    }
    
    // Delete staff member
    public function deleteStaff($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $userName = $user->name;
            
            // Delete the user
            $user->delete();
            
            // Flash success message
            session()->flash('message', "Staff member '$userName' was deleted successfully.");
            
            // Clear any selected actions
            $this->showActions = [];
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete staff member: ' . $e->getMessage());
        }
    }
    
    // Close the form
    public function closeForm()
    {
        $this->showForm = false;
        $this->resetForm();
    }
    
    // Reset form fields
    private function resetForm()
    {
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->regno = '';
        $this->role_id = '';
        $this->level_id = '';
        $this->generatedPassword = '';
        $this->resetErrorBag();
    }
    
    public function render()
    {
        // Get roles and levels for filters
        $roles = Role::all();
        $levels = Level::all();
        
        // Build query with filters
        $staff = User::query()
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('regno', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter, function ($query) {
                return $query->where('role_id', $this->roleFilter);
            })
            ->when($this->levelFilter, function ($query) {
                return $query->where('level_id', $this->levelFilter);
            })
            ->with(['role', 'level'])
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
            
        return view('livewire.backend.staff.table-list', [
            'staff' => $staff,
            'roles' => $roles,
            'levels' => $levels
        ]);
    }




   
}
