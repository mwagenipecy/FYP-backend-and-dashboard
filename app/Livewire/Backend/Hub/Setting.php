<?php

namespace App\Livewire\Backend\Hub;

use Livewire\Component;
use App\Models\Hub;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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
    public $website;
    public $established_date;
    public $operating_hours;
    public $specialties = [];
    public $social_media = [
        'facebook' => '',
        'twitter' => '',
        'instagram' => '',
        'linkedin' => ''
    ];
    
    // Editor states
    public $activeEditor = null;
    
    // UI states
    public $success = false;
    public $loading = false;
    public $currentTab = 'basic';
    public $imagePreview = null;
    
    // Available specialties
    public $availableSpecialties = [
        'Technology', 'Healthcare', 'Education', 'Finance', 
        'Marketing', 'Consulting', 'Manufacturing', 'Retail'
    ];
    
    // Validation rules
    protected $rules = [
        'name' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'address' => 'required|string|max:500',
        'status' => 'required|in:active,inactive,pending',
        'about' => 'nullable|string|max:5000',
        'mission' => 'nullable|string|max:2000',
        'vision' => 'nullable|string|max:2000',
        'description' => 'nullable|string|max:1000',
        'website' => 'nullable|url|max:255',
        'established_date' => 'nullable|date|before_or_equal:today',
        'operating_hours' => 'nullable|string|max:255',
        'newImage' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,webp',
        'social_media.facebook' => 'nullable|url',
        'social_media.twitter' => 'nullable|url',
        'social_media.instagram' => 'nullable|url',
        'social_media.linkedin' => 'nullable|url',
    ];

    // Custom validation messages
    protected $messages = [
        'name.required' => 'Hub name is required.',
        'email.email' => 'Please enter a valid email address.',
        'newImage.max' => 'Image size should not exceed 2MB.',
        'newImage.mimes' => 'Only JPEG, PNG, JPG, and WebP images are allowed.',
        'website.url' => 'Please enter a valid website URL.',
        'established_date.before_or_equal' => 'Established date cannot be in the future.',
    ];
    
    public function mount($hubId)
    {
        try {
            $this->hubId = $hubId;
            $this->loadHub();
        } catch (\Exception $e) {
            Log::error('Error mounting Hub Settings: ' . $e->getMessage());
            session()->flash('error', 'Failed to load hub settings.');
        }
    }
    
    public function loadHub()
    {
        $this->hub = Hub::findOrFail($this->hubId);
        
        // Load hub details into form fields
        $this->name = $this->hub->name;
        $this->phone_number = $this->hub->phone_number;
        $this->email = $this->hub->email;
        $this->address = $this->hub->address;
        $this->status = $this->hub->status ?? 'pending';
        $this->about = $this->hub->about;
        $this->mission = $this->hub->mission;
        $this->vision = $this->hub->vision;
        $this->description = $this->hub->description;
        $this->image = $this->hub->image;
        $this->website = $this->hub->website;
        $this->established_date = $this->hub->established_date;
        $this->operating_hours = $this->hub->operating_hours;
        $this->specialties = $this->hub->specialties ? json_decode($this->hub->specialties, true) : [];
        $this->social_media = array_merge($this->social_media, $this->hub->social_media ? json_decode($this->hub->social_media, true) : []);
    }
    
    public function setActiveEditor($editor)
    {
        // Close other editors when opening a new one
        $this->activeEditor = $this->activeEditor === $editor ? null : $editor;
    }
    
    public function setCurrentTab($tab)
    {
        $this->currentTab = $tab;
        $this->activeEditor = null; // Close any open editor when switching tabs
    }
    
    public function addSpecialty($specialty)
    {
        if (!in_array($specialty, $this->specialties)) {
            $this->specialties[] = $specialty;
        }
    }
    
    public function removeSpecialty($index)
    {
        unset($this->specialties[$index]);
        $this->specialties = array_values($this->specialties);
    }
    
    public function updatedNewImage()
    {
        $this->validate(['newImage' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,webp']);
        
        if ($this->newImage) {
            $this->imagePreview = $this->newImage->temporaryUrl();
        }
    }
    
    public function removeImage()
    {
        $this->newImage = null;
        $this->imagePreview = null;
        $this->reset(['newImage']);
    }
    
    public function validateField($field)
    {
        $this->validateOnly($field);
    }
    
    public function saveHub()
    {
        try {
            $this->loading = true;
            
            // Auto-set status based on completion
            $this->updateStatusBasedOnCompletion();
            
            // Validate the input
            $this->validate();
            
            // Handle image upload if there's a new image
            if ($this->newImage) {
                $this->handleImageUpload();
            }
            
            // Prepare data for update
            $updateData = $this->prepareUpdateData();
            
            // Update the hub
            $this->hub->update($updateData);
            
            // Set success message
            $this->success = true;
            
            // Reset states
            $this->activeEditor = null;
            $this->imagePreview = null;
            $this->newImage = null;
            
            // Reload hub data
            $this->loadHub();
            
            // Clear success message after 5 seconds
            $this->dispatch('clearMessage');
            
            Log::info('Hub settings updated successfully', ['hub_id' => $this->hubId, 'user_id' => Auth::id()]);
            
        } catch (\Exception $e) {
            Log::error('Error saving hub settings: ' . $e->getMessage(), [
                'hub_id' => $this->hubId,
                'user_id' => Auth::id(),
                'error' => $e->getTraceAsString()
            ]);
            
            session()->flash('error', 'Failed to save hub settings. Please try again.');
        } finally {
            $this->loading = false;
        }
    }
    
    private function updateStatusBasedOnCompletion()
    {
        // Auto-update status based on completion percentage
        $completionPercentage = $this->getCompletionPercentage();
        
        if ($completionPercentage >= 80 && $this->status === 'pending') {
            $this->status = 'active';
        } elseif ($completionPercentage < 50 && $this->status === 'active') {
            $this->status = 'pending';
        }
    }
    
    private function handleImageUpload()
    {
        // Delete old image if it exists and is not the default image
        if ($this->image && 
            $this->image !== 'storage/hub_images/default.png' && 
            Storage::exists(str_replace('storage/', 'public/', $this->image))) {
            Storage::delete(str_replace('storage/', 'public/', $this->image));
        }
        
        // Store the new image with a unique name
        $imageName = 'hub_' . $this->hubId . '_' . time() . '.' . $this->newImage->getClientOriginalExtension();
        $imagePath = $this->newImage->storeAs('hub_images', $imageName, 'public');
        $this->image = 'storage/' . $imagePath;
    }
    
    private function prepareUpdateData()
    {
        return [
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
            'website' => $this->website,
            'established_date' => $this->established_date,
            'operating_hours' => $this->operating_hours,
            'specialties' => json_encode(array_values($this->specialties)),
            'social_media' => json_encode($this->social_media),
            'updated_by' => Auth::id(),
            'updated_at' => now(),
        ];
    }
    
    public function getCompletionPercentage()
    {
        $fields = [
            'name', 'email', 'phone_number', 'address', 'description',
            'about', 'mission', 'vision', 'image'
        ];
        
        $completed = 0;
        $total = count($fields);
        
        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $completed++;
            }
        }
        
        return round(($completed / $total) * 100);
    }
    
    public function getStatusBadgeColor()
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800 border-green-200',
            'inactive' => 'bg-red-100 text-red-800 border-red-200',
            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200'
        };
    }
    
    public function resetForm()
    {
        $this->loadHub();
        $this->activeEditor = null;
        $this->imagePreview = null;
        $this->newImage = null;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.backend.hub.setting', [
            'completionPercentage' => $this->getCompletionPercentage(),
            'statusBadgeColor' => $this->getStatusBadgeColor(),
        ]);
    }
}