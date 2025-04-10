<?php

namespace App\Livewire\Backend\Hub;

use Livewire\Component;
use App\Models\Hub;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class Setting extends Component
{


    use WithFileUploads;
    
    public $hub;
    public $hubId;
    
    // Form fields
    public $name;
    public $phone_number;
    public $email;
    public $address;
    public $status;
    public $about;
    public $mission;
    public $vision;
    public $description;
    public $image;
    public $newImage;
    
    // Editor states
    public $activeEditor = null;
    
    // Success message
    public $success = false;
    
    // Validation rules
    protected $rules = [
        'name' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'address' => 'required|string|max:255',
        'status' => 'required|in:active,inactive',
        'about' => 'nullable|string',
        'mission' => 'nullable|string',
        'vision' => 'nullable|string',
        'description' => 'nullable|string',
        'newImage' => 'nullable|image|max:2048',
    ];
    
    public function mount($hubId)
    {
        $this->hubId = $hubId;
        $this->loadHub();
    }
    
    public function loadHub()
    {
        $this->hub = Hub::findOrFail($this->hubId);
        
        // Load hub details into form fields
        $this->name = $this->hub->name;
        $this->phone_number = $this->hub->phone_number;
        $this->email = $this->hub->email;
        $this->address = $this->hub->address;
        $this->status = $this->hub->status;
        $this->about = $this->hub->about;
        $this->mission = $this->hub->mission;
        $this->vision = $this->hub->vision;
        $this->description = $this->hub->description;
        $this->image = $this->hub->image;
    }
    
    public function setActiveEditor($editor)
    {
        $this->activeEditor = $editor;
    }
    
    public function saveHub()
    {
        // Validate the input
        $this->validate();
        
        // Handle image upload if there's a new image
        if ($this->newImage) {
            // Delete old image if it exists and is not the default image
            if ($this->image && $this->image != 'storage/hub_images/default.png' && Storage::exists(str_replace('storage/', 'public/', $this->image))) {
                Storage::delete(str_replace('storage/', 'public/', $this->image));
            }
            
            // Store the new image
            $imagePath = $this->newImage->store('hub_images', 'public');
            $this->image = 'storage/' . $imagePath;
        }
        
        // Update the hub
        $this->hub->update([
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'address' => $this->address,
            'status' => $this->status,
            'about' => $this->about,
            'mission' => $this->mission,
            'vision' => $this->vision,
            'description' => $this->description,
            'image' => $this->image,
            'updated_by' => Auth::id(),
        ]);
        
        // Set success message
        $this->success = true;
        
        // Reset active editor
        $this->activeEditor = null;
        
        // Clear success message after 3 seconds
        $this->dispatch('clearMessage');
    }


    public function render()
    {
        return view('livewire.backend.hub.setting');
    }
}
