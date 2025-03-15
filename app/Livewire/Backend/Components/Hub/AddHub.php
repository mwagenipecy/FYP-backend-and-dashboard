<?php

namespace App\Livewire\Backend\Components\Hub;

use Livewire\Component;
use App\Models\Hub;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AddHub extends Component
{
    public $name;
    public $email;
    public $phone_number;
    public $address;
    public $supervisor_id;
    
    public $supervisors = [];
    public $successMessage = '';
    public $errorMessage = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:hubs,email',
        'phone_number' => 'required|string|max:20',
        'address' => 'required|string',
        'supervisor_id' => 'nullable|exists:users,id',
    ];

    protected $messages = [
        'name.required' => 'The hub name is required.',
        'email.required' => 'Email address is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already registered for another hub.',
        'phone_number.required' => 'Phone number is required.',
        'address.required' => 'Address is required.',
        'supervisor_id.exists' => 'Please select a valid supervisor.',
    ];

    public function mount()
    {
        // Load supervisors for dropdown
        $this->supervisors = User::
                           get(['id', 'name']);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        
        // Clear messages when user starts typing again
        $this->successMessage = '';
        $this->errorMessage = '';
    }

    public function register()
    {
        try {
            $this->validate();
            
            Hub::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'address' => $this->address,
                'supervisor_id' => $this->supervisor_id,
                'created_by' => Auth::id(),
                'status' => 'inactive',
            ]);
            
            $this->reset(['name', 'email', 'phone_number', 'address', 'supervisor_id']);
            $this->successMessage = 'Hub registered successfully!';
        } catch (\Exception $e) {
            $this->errorMessage = 'Error registering hub: ' . $e->getMessage();
        }
    }


    public function render()
    {
        return view('livewire.backend.components.hub.add-hub');
    }
}
