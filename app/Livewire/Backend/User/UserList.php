<?php

namespace App\Livewire\Backend\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
class UserList extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';
    public $typeFilter = '';
    public $ratingFilter = '';
    public $countryFilter = '';
    public $showFilters = 'all';
    
    public $selectedUsers = [];
    public $selectAll = false;
    
    // For user editing
    public $editingUser = null;
    public $name, $email, $regno, $role_id, $status;
    
    // For modals
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showActions = false;
    public $userToDelete = null;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'ratingFilter' => ['except' => ''],
        'countryFilter' => ['except' => ''],
        'showFilters' => ['except' => 'all'],
    ];
    
    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'role_id' => 'required|exists:roles,id',
        'status' => 'required|in:active,inactive,pending'
    ];

    public function mount()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function export() 
    {
        $filename = 'users_export_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new UsersExport($this->selectedUsers), $filename);
    }
    
    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedUsers = $this->users->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }
    
    public function toggleShowFilters($type)
    {
        $this->showFilters = $type;
    }
    
    public function editUser($userId)
    {
        $this->resetValidation();
        $this->editingUser = User::find($userId);
        $this->name = $this->editingUser->name;
        $this->email = $this->editingUser->email;
        $this->regno = $this->editingUser->regno;
        $this->role_id = $this->editingUser->role_id;
        $this->status = $this->editingUser->status ?? 'active';
        $this->showEditModal = true;
    }
    
    public function cancelEdit()
    {
        $this->showEditModal = false;
        $this->editingUser = null;
        $this->reset(['name', 'email', 'regno', 'role_id', 'status']);
    }
    
    public function saveUser()
    {
        $this->validate();
        
        $this->editingUser->update([
            'name' => $this->name,
            'email' => $this->email,
            'regno' => $this->regno,
            'role_id' => $this->role_id,
            'status' => $this->status,
        ]);
        
        $this->showEditModal = false;
        $this->editingUser = null;
        $this->reset(['name', 'email', 'regno', 'role_id', 'status']);
        
        session()->flash('message', 'User updated successfully.');
    }
    
    public function confirmUserDeletion($userId)
    {
        $this->userToDelete = $userId;
        $this->showDeleteModal = true;
    }
    
    public function deleteUser()
    {
        $user = User::find($this->userToDelete);
        $user->delete();
        
        $this->showDeleteModal = false;
        $this->userToDelete = null;
        
        session()->flash('message', 'User deleted successfully.');
    }
    
    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->userToDelete = null;
    }
    
    public function activateUser($userId)
    {
        User::where('id', $userId)->update(['status' => 'active']);
        session()->flash('message', 'User activated successfully.');
    }
    
    public function deactivateUser($userId)
    {
        User::where('id', $userId)->update(['status' => 'inactive']);
        session()->flash('message', 'User deactivated successfully.');
    }
    
    public function blockUser($userId)
    {
        User::where('id', $userId)->update(['status' => 'blocked']);
        session()->flash('message', 'User blocked successfully.');
    }
    
    public function batchAction($action)
    {
        if (count($this->selectedUsers) > 0) {
            if ($action === 'activate') {
                User::whereIn('id', $this->selectedUsers)->update(['status' => 'active']);
                session()->flash('message', count($this->selectedUsers) . ' users activated.');
            } elseif ($action === 'deactivate') {
                User::whereIn('id', $this->selectedUsers)->update(['status' => 'inactive']);
                session()->flash('message', count($this->selectedUsers) . ' users deactivated.');
            } elseif ($action === 'block') {
                User::whereIn('id', $this->selectedUsers)->update(['status' => 'blocked']);
                session()->flash('message', count($this->selectedUsers) . ' users blocked.');
            } elseif ($action === 'delete') {
                User::whereIn('id', $this->selectedUsers)->delete();
                session()->flash('message', count($this->selectedUsers) . ' users deleted.');
                $this->selectedUsers = [];
            }
        } else {
            session()->flash('error', 'No users selected.');
        }
    }
    
    public function getUsersProperty()
    {
        return $this->usersQuery->get();
    }
    
    public function getUsersQueryProperty(): Builder
    {
        $query = User::query()
            ->with('role', 'level')
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
            ->when($this->statusFilter, function ($query) {
                return $query->where('status', $this->statusFilter);
            })
            ->when($this->typeFilter, function ($query) {
                // Assuming type is determined by a field or relationship
                if ($this->typeFilter === 'pro') {
                    return $query->where('current_team_id', '!=', null);
                } else {
                    return $query->where('current_team_id', null);
                }
            })
            ->when($this->countryFilter, function ($query) {
                // Assuming country is stored in a profile or separate table
                return $query->whereHas('profile', function ($q) {
                    $q->where('country', $this->countryFilter);
                });
            })
            ->orderBy('created_at', 'desc');
            
        return $query;
    }
    
    public function getRolesProperty()
    {
        return Role::all();
    }
    
    public function getCountriesProperty()
    {
        // You might want to replace this with a real countries table or API
        return ['United States', 'England', 'France', 'Germany', 'Spain', 'Italy', 'Japan', 'Australia'];
    }
    
    public function render()
    {
        return view('livewire.backend.user.user-list', [
            'users' => $this->usersQuery->paginate(10),
            'roles' => $this->roles,
            'countries' => $this->countries,
        ]);
    }



}
