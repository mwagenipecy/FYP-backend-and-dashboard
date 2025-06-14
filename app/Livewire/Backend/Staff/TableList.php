<?php

namespace App\Livewire\Backend\Staff;

use App\Models\User;
use App\Models\Role;
use App\Models\Level;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Services\DirectEmailService;

class TableList extends Component
{
    use WithPagination;
    
    // Search and filter properties
    public $search = '';
    public $userTypeFilter = '';
    public $statusFilter = '';
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
    
    // Status modal properties
    public $showStatusModal = false;
    public $statusModalTitle = '';
    public $statusModalMessage = '';
    public $statusModalButtonText = '';
    public $statusModalButtonClass = '';
    public $pendingStatusChange = null;
    public $pendingUserId = null;
    
    // Form fields
    public $name = '';
    public $email = '';
    public $userType = '';
    public $status = 'active';
    public $regno = '';
    public $fieldType = '';
    public $role_id = '';
    public $level_id = '';
    public $password = '';
    public $generatedPassword = '';
    
    // Field type options for staff
    public $fieldTypeOptions = [
        'Technology' => 'Technology',
        'Education' => 'Education',
        'Health' => 'Health',
        'IoT' => 'Internet of Things (IoT)',
        'Engineering' => 'Engineering',
        'Business' => 'Business & Management',
        'Science' => 'Science & Research',
        'Arts' => 'Arts & Humanities',
        'Other' => 'Other'
    ];
    
    // Validation rules
    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'userType' => 'required|in:student,staff',
            'status' => 'required|in:active,inactive,disabled,blocked,pending',
            'role_id' => 'required|exists:roles,id',
            'level_id' => 'required|exists:levels,id',
        ];
        
        // Add conditional validation based on user type
        if ($this->userType === 'student') {
            $rules['regno'] = 'nullable|string|max:50';
            $rules['fieldType'] = 'nullable';
        } elseif ($this->userType === 'staff') {
            $rules['fieldType'] = 'required|string|max:50';
            $rules['regno'] = 'nullable';
        }
        
        // Add unique validation for email and regno, but exclude current user when editing
        if ($this->formMode === 'create') {
            $rules['email'] .= '|unique:users,email';
            if ($this->userType === 'student' && $this->regno) {
                $rules['regno'] .= '|unique:users,regno';
            }
        } else {
            $rules['email'] .= '|unique:users,email,' . $this->userId;
            if ($this->userType === 'student' && $this->regno) {
                $rules['regno'] .= '|unique:users,regno,' . $this->userId;
            }
        }
        
        return $rules;
    }
    
    // Custom validation messages
    protected function messages()
    {
        return [
            'userType.required' => 'Please select a user type.',
            'userType.in' => 'User type must be either student or staff.',
            'fieldType.required' => 'Field of expertise is required for staff members.',
            'regno.unique' => 'This registration number is already taken.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Invalid status selected.',
        ];
    }
    
    // Reset pagination when filters change
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function updatedUserTypeFilter()
    {
        $this->resetPage();
    }
    
    public function updatedStatusFilter()
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
    
    // Handle user type change in form
    public function handleUserTypeChange()
    {
        if ($this->userType === 'student') {
            $this->fieldType = '';
        } elseif ($this->userType === 'staff') {
            $this->regno = '';
        }
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
            $this->showActions = [];
            $this->showActions[$userId] = true;
        }
    }
    
    // Show create form
    public function createUser()
    {
        $this->resetForm();
        $this->generatePassword();
        $this->formMode = 'create';
        $this->showForm = true;
    }
    
    // Show edit form
    public function editUser($userId)
    {
        $this->resetForm();
        $this->userId = $userId;
        $this->formMode = 'edit';
        
        $user = User::findOrFail($userId);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->userType = $user->userType ?? '';
        $this->status = $user->status ?? 'active';
        $this->regno = $user->regno;
        $this->fieldType = $user->fieldType;
        $this->role_id = $user->role_id;
        $this->level_id = $user->level_id;
        
        $this->showForm = true;
    }
    
    // Save user (create or update)
    public function saveUser()
    {
        $this->validate();
        
        if ($this->formMode === 'create') {
            // Create new user
            $user = new User();
            $user->password = Hash::make($this->generatedPassword);
            $isNewUser = true;
        } else {
            // Update existing user
            $user = User::findOrFail($this->userId);
            $isNewUser = false;
        }
        
        $user->name = $this->name;
        $user->email = $this->email;
        $user->userType = $this->userType;
        $user->status = $this->status;
        $user->role_id = $this->role_id;
        $user->level_id = $this->level_id;
        
        // Set regno or fieldType based on user type
        if ($this->userType === 'student') {
            $user->regno = $this->regno;
            $user->fieldType = null;
        } elseif ($this->userType === 'staff') {
            $user->fieldType = $this->fieldType;
            $user->regno = null;
        }
        
        $user->save();
        
        // 🎯 SEND WELCOME EMAIL FOR NEW USERS
        if ($isNewUser) {
            $emailResult = DirectEmailService::sendWelcomeEmail($user, $this->generatedPassword);
            $userTypeText = ucfirst($this->userType);
            
            if ($emailResult['success']) {
                session()->flash('message', 
                    $userTypeText . ' created successfully! Welcome email sent to ' . $user->email . 
                    '. Password: ' . $this->generatedPassword
                );
            } else {
                session()->flash('warning', 
                    $userTypeText . ' created successfully, but welcome email failed to send. ' .
                    'Password: ' . $this->generatedPassword . '. Error: ' . $emailResult['message']
                );
            }
        } else {
            $userTypeText = ucfirst($this->userType);
            session()->flash('message', $userTypeText . ' updated successfully.');
        }
        
        $this->closeForm();
    }




    // Status management methods
    public function disableUser($userId)
    {
        $user = User::findOrFail($userId);
        $this->showStatusChangeModal(
            'Disable User',
            "Are you sure you want to disable {$user->name}? They will not be able to access the system until re-enabled.",
            'Disable User',
            'bg-yellow-600',
            'disabled',
            $userId
        );
    }
    
    public function enableUser($userId)
    {
        $user = User::findOrFail($userId);
        $this->showStatusChangeModal(
            'Enable User',
            "Are you sure you want to enable {$user->name}? They will regain access to the system.",
            'Enable User',
            'bg-green-600',
            'active',
            $userId
        );
    }
    
    public function blockUser($userId)
    {
        $user = User::findOrFail($userId);
        $this->showStatusChangeModal(
            'Block User',
            "Are you sure you want to block {$user->name}? This is a stronger restriction than disabling and should be used for security concerns.",
            'Block User',
            'bg-red-600',
            'blocked',
            $userId
        );
    }
    
    public function unblockUser($userId)
    {
        $user = User::findOrFail($userId);
        $this->showStatusChangeModal(
            'Unblock User',
            "Are you sure you want to unblock {$user->name}? They will be able to access the system again.",
            'Unblock User',
            'bg-green-600',
            'active',
            $userId
        );
    }
    
    public function activateUser($userId)
    {
        $user = User::findOrFail($userId);
        $this->showStatusChangeModal(
            'Activate User',
            "Are you sure you want to activate {$user->name}?",
            'Activate User',
            'bg-green-600',
            'active',
            $userId
        );
    }
    
    // Show status change modal
    // private function showStatusChangeModal($title, $message, $buttonText, $buttonClass, $newStatus, $userId)
    // {
    //     $this->statusModalTitle = $title;
    //     $this->statusModalMessage = $message;
    //     $this->statusModalButtonText = $buttonText;
    //     $this->statusModalButtonClass = $buttonClass;
    //     $this->pendingStatusChange = $newStatus;
    //     $this->pendingUserId = $userId;
    //     $this->showStatusModal = true;
    //     $this->showActions = []; // Close action menus
    // }
    
    // Confirm status change
    public function confirmStatusChange()
    {
        if ($this->pendingUserId && $this->pendingStatusChange) {
            try {
                $user = User::findOrFail($this->pendingUserId);
                $oldStatus = $user->status ?? 'inactive';
                $newStatus = $this->pendingStatusChange;
                
                // Update user status
                $user->status = $newStatus;
                $user->save();
                
                // Determine reason based on status change
                $reason = $this->getStatusChangeReason($oldStatus, $newStatus);
                
                // 🎯 SEND STATUS CHANGE EMAIL
                $emailResult = DirectEmailService::sendStatusChangeEmail($user, $oldStatus, $newStatus, $reason);
                
                $statusText = ucfirst($newStatus);
                
                if ($emailResult['success']) {
                    session()->flash('message', 
                        "User {$user->name} has been {$statusText}. " .
                        "Notification email sent to {$user->email}."
                    );
                } else {
                    session()->flash('warning', 
                        "User {$user->name} has been {$statusText}, " .
                        "but notification email failed to send. Error: " . $emailResult['message']
                    );
                }
                
                // Log the status change
                \Log::info("User status changed", [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'reason' => $reason,
                    'changed_by' => auth()->id() ?? 'system',
                    'email_sent' => $emailResult['success']
                ]);
                
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to update user status: ' . $e->getMessage());
            }
        }
        
        $this->cancelStatusChange();
    }



    private function getFilteredUsers()
    {
        return User::query()
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('regno', 'like', '%' . $this->search . '%')
                      ->orWhere('fieldType', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->userTypeFilter, function ($query) {
                return $query->where('userType', $this->userTypeFilter);
            })
            ->when($this->statusFilter, function ($query) {
                return $query->where('status', $this->statusFilter);
            })
            ->when($this->roleFilter, function ($query) {
                return $query->where('role_id', $this->roleFilter);
            })
            ->when($this->levelFilter, function ($query) {
                return $query->where('level_id', $this->levelFilter);
            })
            ->get();
    }

    // public function cancelStatusChange()
    // {
    //     $this->showStatusModal = false;
    //     $this->statusModalTitle = '';
    //     $this->statusModalMessage = '';
    //     $this->statusModalButtonText = '';
    //     $this->statusModalButtonClass = '';
    //     $this->pendingStatusChange = null;
    //     $this->pendingUserId = null;
    // }





    public function sendBulkNotification()
    {
        // Get filtered users based on current filters
        $users = $this->getFilteredUsers();
        
        if ($users->count() === 0) {
            session()->flash('warning', 'No users found to send notifications to.');
            return;
        }
        
        // Prepare recipients array
        $recipients = $users->map(function ($user) {
            return [
                'email' => $user->email,
                'name' => $user->name
            ];
        })->toArray();
        
        // Custom notification content
        $subject = 'Important System Update - ' . config('app.name');
        $htmlContent = "
        <h2>Hello {{name}}!</h2>
        <p>We wanted to inform you about an important system update.</p>
        <p>Please log in to your account to review any changes that may affect you.</p>
        <div style='text-align: center; margin: 20px 0;'>
            <a href='" . url('/login') . "' style='background-color: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px;'>Login to Account</a>
        </div>
        <p>If you have any questions, please contact our support team.</p>
        ";
        
        // 🎯 SEND BULK EMAILS
        $results = DirectEmailService::sendBulkEmail($recipients, $subject, $htmlContent);
        
        // Process results
        $successCount = collect($results)->where('success', true)->count();
        $failCount = collect($results)->where('success', false)->count();
        
        if ($failCount === 0) {
            session()->flash('message', 
                "Bulk notification sent successfully to {$successCount} users."
            );
        } else {
            session()->flash('warning', 
                "Bulk notification completed. {$successCount} sent successfully, {$failCount} failed."
            );
        }
    }

    // ===== 5. INFORMATION UPDATE NOTIFICATIONS =====
    
    public function notifyProfileUpdate($userId)
    {
        try {
            $user = User::findOrFail($userId);
            
            // 🎯 SEND PROFILE UPDATE NOTIFICATION
            $emailResult = DirectEmailService::sendTemplatedEmail(
                $user->email,
                'Profile Updated - ' . config('app.name'),
                [
                    'title' => 'Profile Information Updated',
                    'content' => "Hello {$user->name}! Your profile information has been updated by an administrator. Please review your account details to ensure everything is correct.",
                    'button_text' => 'Review Profile',
                    'button_url' => url('/profile')
                ]
            );
            
            if ($emailResult['success']) {
                session()->flash('info', 
                    "Profile update notification sent to {$user->name} at {$user->email}."
                );
            } else {
                session()->flash('warning', 
                    "Failed to send profile update notification. Error: " . $emailResult['message']
                );
            }
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to send notification: ' . $e->getMessage());
        }
    }

    // ===== HELPER METHODS =====
    
    private function showStatusChangeModal($title, $message, $buttonText, $buttonClass, $newStatus, $userId)
    {
        $this->statusModalTitle = $title;
        $this->statusModalMessage = $message;
        $this->statusModalButtonText = $buttonText;
        $this->statusModalButtonClass = $buttonClass;
        $this->pendingStatusChange = $newStatus;
        $this->pendingUserId = $userId;
        $this->showStatusModal = true;
        $this->showActions = []; // Close action menus
    }
    
    private function getStatusChangeReason($oldStatus, $newStatus)
    {
        $reasons = [
            'active_to_disabled' => 'Account temporarily disabled by administrator',
            'active_to_blocked' => 'Account blocked due to security concerns',
            'disabled_to_active' => 'Account re-enabled by administrator',
            'blocked_to_active' => 'Account unblocked - access restored',
            'pending_to_active' => 'Account activated and ready for use'
        ];
        
        $key = $oldStatus . '_to_' . $newStatus;
        return $reasons[$key] ?? 'Account status updated by administrator';
    }



    
    // Cancel status change
    public function cancelStatusChange()
    {
        $this->showStatusModal = false;
        $this->statusModalTitle = '';
        $this->statusModalMessage = '';
        $this->statusModalButtonText = '';
        $this->statusModalButtonClass = '';
        $this->pendingStatusChange = null;
        $this->pendingUserId = null;
    }
    
    // Reset password

    public function resetPassword($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $newPassword = Str::random(8);
            
            // Update password in database
            $user->password = Hash::make($newPassword);
            $user->save();
            
            
            // 🎯 SEND PASSWORD RESET EMAIL
            $emailResult = DirectEmailService::sendPasswordResetEmail($user, $newPassword);
            
            if ($emailResult['success']) {
                session()->flash('info', 
                    "Password reset successfully for {$user->name}. " .
                    "Reset email sent to {$user->email}."
                );
            } else {
                session()->flash('warning', 
                    "Password reset for {$user->name}, but email failed to send. " .
                    "New password: {$newPassword}. Error: " . $emailResult['message']
                );
            }
            
            $this->showActions = [];
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to reset password: ' . $e->getMessage());
        }
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
    
    // Delete user
    public function deleteUser($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $userName = $user->name;
            $userType = ucfirst($user->userType ?? 'User');
            
            $user->delete();
            
            session()->flash('message', "$userType '$userName' was deleted successfully.");
            $this->showActions = [];
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete user: ' . $e->getMessage());
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
        $this->userType = '';
        $this->status = 'active';
        $this->regno = '';
        $this->fieldType = '';
        $this->role_id = '';
        $this->level_id = '';
        $this->generatedPassword = '';
        $this->resetErrorBag();
    }
    
    public function render()
    {
        $roles = Role::all();
        $levels = Level::all();
        
        // Build query with filters
        $users = User::query()
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('regno', 'like', '%' . $this->search . '%')
                      ->orWhere('fieldType', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->userTypeFilter, function ($query) {
                return $query->where('userType', $this->userTypeFilter);
            })
            ->when($this->statusFilter, function ($query) {
                return $query->where('status', $this->statusFilter);
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
            'users' => $users,
            'roles' => $roles,
            'levels' => $levels
        ]);
    }
}