<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Hub Settings</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Manage and customize your hub profile - {{ $hub->name }}
                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Completion Progress -->
                    <div class="flex items-center space-x-2">
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                                 style="width: {{ $completionPercentage }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ $completionPercentage }}% Complete</span>
                    </div>
                    <!-- Status Badge -->
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $statusBadgeColor }}">
                        <span class="w-2 h-2 rounded-full mr-2 
                            {{ $status === 'active' ? 'bg-green-400' : 
                               ($status === 'inactive' ? 'bg-red-400' : 'bg-yellow-400') }}"></span>
                        {{ ucfirst($status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if($success)
        <div id="success-message" class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm text-green-700 font-medium">Hub settings updated successfully!</p>
            </div>
        </div>
        @endif

        @if (session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button 
                        wire:click="setCurrentTab('basic')"
                        class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors duration-200
                               {{ $currentTab === 'basic' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                    >
                        <i class="fas fa-info-circle mr-2"></i>
                        Basic Information
                    </button>
                    <button 
                        wire:click="setCurrentTab('content')"
                        class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors duration-200
                               {{ $currentTab === 'content' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                    >
                        <i class="fas fa-edit mr-2"></i>
                        Content & Branding
                    </button>
                    <button 
                        wire:click="setCurrentTab('social')"
                        class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors duration-200
                               {{ $currentTab === 'social' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                    >
                        <i class="fas fa-share-alt mr-2"></i>
                        Social & Contact
                    </button>
                </nav>
            </div>

            <!-- Form Content -->
            <form wire:submit.prevent="saveHub" class="p-6">
                <!-- Basic Information Tab -->
                @if($currentTab === 'basic')
                <div class="space-y-8">
                    <!-- Hub Image Section -->
                    <div class="flex flex-col items-center space-y-6 py-8 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Hub Logo</h3>
                        
                        <!-- Image Preview -->
                        <div class="relative">
                            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg">
                                @if ($imagePreview)
                                    <img src="{{ $imagePreview }}" alt="New Image" class="w-full h-full object-cover">
                                @elseif ($image)
                                    <img src="{{ asset($image) }}" alt="{{ $name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                        <i class="fas fa-building text-3xl text-blue-400"></i>
                                    </div>
                                @endif
                            </div>
                            
                            @if($imagePreview)
                            <button 
                                type="button" 
                                wire:click="removeImage"
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600 transition-colors"
                            >
                                <i class="fas fa-times text-sm"></i>
                            </button>
                            @endif
                        </div>

                        <!-- Upload Button -->
                        <div class="flex flex-col items-center space-y-2">
                            <label for="newImage" class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                                <i class="fas fa-camera"></i>
                                <span>{{ $image ? 'Change Logo' : 'Upload Logo' }}</span>
                            </label>
                            <input id="newImage" type="file" wire:model="newImage" class="hidden" accept="image/*">
                            <p class="text-xs text-gray-500">PNG, JPG, WebP up to 2MB</p>
                        </div>
                        
                        @error('newImage') 
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Basic Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Hub Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Hub Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                wire:model.blur="name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Enter your hub name"
                            >
                            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input 
                                    type="email" 
                                    id="email" 
                                    wire:model.blur="email"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="contact@hub.com"
                                >
                            </div>
                            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input 
                                    type="text" 
                                    id="phone_number" 
                                    wire:model.blur="phone_number"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="+1 (555) 123-4567"
                                >
                            </div>
                            @error('phone_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Website -->
                        <div>
                            <label for="website" class="block text-sm font-semibold text-gray-700 mb-2">Website</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-globe text-gray-400"></i>
                                </div>
                                <input 
                                    type="url" 
                                    id="website" 
                                    wire:model.blur="website"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="https://www.example.com"
                                >
                            </div>
                            @error('website') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Established Date -->
                        <div>
                            <label for="established_date" class="block text-sm font-semibold text-gray-700 mb-2">Established Date</label>
                            <input 
                                type="date" 
                                id="established_date" 
                                wire:model.blur="established_date"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            >
                            @error('established_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                Address <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                </div>
                                <textarea 
                                    id="address" 
                                    wire:model.blur="address"
                                    rows="3"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Enter your complete address"
                                ></textarea>
                            </div>
                            @error('address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Operating Hours -->
                        <div>
                            <label for="operating_hours" class="block text-sm font-semibold text-gray-700 mb-2">Operating Hours</label>
                            <input 
                                type="text" 
                                id="operating_hours" 
                                wire:model.blur="operating_hours"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="e.g., Mon-Fri 9AM-6PM"
                            >
                            @error('operating_hours') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="status" 
                                wire:model.blur="status"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            >
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="pending">Pending</option>
                            </select>
                            @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Specialties Section -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Specialties</label>
                        <div class="space-y-4">
                            <!-- Selected Specialties -->
                            @if(count($specialties) > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($specialties as $index => $specialty)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $specialty }}
                                    <button 
                                        type="button" 
                                        wire:click="removeSpecialty({{ $index }})"
                                        class="ml-2 text-blue-600 hover:text-blue-800"
                                    >
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </span>
                                @endforeach
                            </div>
                            @endif
                            
                            <!-- Available Specialties -->
                            <div class="flex flex-wrap gap-2">
                                @foreach($availableSpecialties as $specialty)
                                    @if(!in_array($specialty, $specialties))
                                    <button 
                                        type="button" 
                                        wire:click="addSpecialty('{{ $specialty }}')"
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors"
                                    >
                                        <i class="fas fa-plus text-xs mr-1"></i>
                                        {{ $specialty }}
                                    </button>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Short Description</label>
                        <textarea 
                            id="description" 
                            wire:model.blur="description"
                            rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Brief description of your hub (max 1000 characters)"
                            maxlength="1000"
                        ></textarea>
                        <div class="flex justify-between items-center mt-1">
                            @error('description') 
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @else
                                <span></span>
                            @enderror
                            <span class="text-xs text-gray-500">{{ strlen($description ?? '') }}/1000</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Content & Branding Tab -->
                @if($currentTab === 'content')
                <div class="space-y-8">
                    <!-- Rich Text Editors -->
                    <!-- About Section -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-b border-gray-200">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">About Us</h3>
                                <p class="text-sm text-gray-600">Tell your story and what makes your hub unique</p>
                            </div>
                            <button 
                                type="button" 
                                wire:click="setActiveEditor('about')" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors"
                            >
                                <i class="fas fa-edit mr-2"></i>
                                {{ $activeEditor === 'about' ? 'Close Editor' : 'Edit Content' }}
                            </button>
                        </div>
                        
                        <div class="p-6">
                            @if($activeEditor === 'about')
                                <div class="border-2 border-blue-300 rounded-lg p-4 bg-blue-50">
                                    <div wire:ignore>
                                        <textarea 
                                            id="about-editor" 
                                            wire:model="about" 
                                            class="w-full rich-editor"
                                            placeholder="Write about your hub's story, values, and what makes you unique..."
                                        >{{ $about }}</textarea>
                                    </div>
                                </div>
                            @else
                                <div class="prose prose-blue max-w-none min-h-[120px] p-4 bg-gray-50 rounded-lg">
                                    @if($about)
                                        {!! $about !!}
                                    @else
                                        <p class="text-gray-500 italic">Click "Edit Content" to add your hub's story...</p>
                                    @endif
                                </div>
                            @endif
                            @error('about') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Mission Section -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-b border-gray-200">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Our Mission</h3>
                                <p class="text-sm text-gray-600">Define your purpose and core objectives</p>
                            </div>
                            <button 
                                type="button" 
                                wire:click="setActiveEditor('mission')" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors"
                            >
                                <i class="fas fa-edit mr-2"></i>
                                {{ $activeEditor === 'mission' ? 'Close Editor' : 'Edit Content' }}
                            </button>
                        </div>
                        
                        <div class="p-6">
                            @if($activeEditor === 'mission')
                                <div class="border-2 border-blue-300 rounded-lg p-4 bg-blue-50">
                                    <div wire:ignore>
                                        <textarea 
                                            id="mission-editor" 
                                            wire:model="mission" 
                                            class="w-full rich-editor"
                                            placeholder="Describe your hub's mission and what you aim to achieve..."
                                        >{{ $mission }}</textarea>
                                    </div>
                                </div>
                            @else
                                <div class="prose prose-blue max-w-none min-h-[120px] p-4 bg-gray-50 rounded-lg">
                                    @if($mission)
                                        {!! $mission !!}
                                    @else
                                        <p class="text-gray-500 italic">Click "Edit Content" to add your mission statement...</p>
                                    @endif
                                </div>
                            @endif
                            @error('mission') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Vision Section -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-b border-gray-200">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Our Vision</h3>
                                <p class="text-sm text-gray-600">Share your long-term goals and aspirations</p>
                            </div>
                            <button 
                                type="button" 
                                wire:click="setActiveEditor('vision')" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors"
                            >
                                <i class="fas fa-edit mr-2"></i>
                                {{ $activeEditor === 'vision' ? 'Close Editor' : 'Edit Content' }}
                            </button>
                        </div>
                        
                        <div class="p-6">
                            @if($activeEditor === 'vision')
                                <div class="border-2 border-blue-300 rounded-lg p-4 bg-blue-50">
                                    <div wire:ignore>
                                        <textarea 
                                            id="vision-editor" 
                                            wire:model="vision" 
                                            class="w-full rich-editor"
                                            placeholder="Outline your hub's vision for the future..."
                                        >{{ $vision }}</textarea>
                                    </div>
                                </div>
                            @else
                                <div class="prose prose-blue max-w-none min-h-[120px] p-4 bg-gray-50 rounded-lg">
                                    @if($vision)
                                        {!! $vision !!}
                                    @else
                                        <p class="text-gray-500 italic">Click "Edit Content" to add your vision statement...</p>
                                    @endif
                                </div>
                            @endif
                            @error('vision') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                @endif

                <!-- Social & Contact Tab -->
                @if($currentTab === 'social')
                <div class="space-y-8">
                    <!-- Social Media Links -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Social Media Profiles</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Facebook -->
                            <div>
                                <label for="facebook" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fab fa-facebook-f text-blue-600 mr-2"></i>Facebook
                                </label>
                                <input 
                                    type="url" 
                                    id="facebook" 
                                    wire:model.blur="social_media.facebook"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="https://facebook.com/yourpage"
                                >
                                @error('social_media.facebook') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Twitter -->
                            <div>
                                <label for="twitter" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fab fa-twitter text-blue-400 mr-2"></i>Twitter
                                </label>
                                <input 
                                    type="url" 
                                    id="twitter" 
                                    wire:model.blur="social_media.twitter"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="https://twitter.com/yourhandle"
                                >
                                @error('social_media.twitter') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Instagram -->
                            <div>
                                <label for="instagram" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fab fa-instagram text-pink-500 mr-2"></i>Instagram
                                </label>
                                <input 
                                    type="url" 
                                    id="instagram" 
                                    wire:model.blur="social_media.instagram"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="https://instagram.com/yourhandle"
                                >
                                @error('social_media.instagram') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- LinkedIn -->
                            <div>
                                <label for="linkedin" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fab fa-linkedin text-blue-700 mr-2"></i>LinkedIn
                                </label>
                                <input 
                                    type="url" 
                                    id="linkedin" 
                                    wire:model.blur="social_media.linkedin"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="https://linkedin.com/company/yourcompany"
                                >
                                @error('social_media.linkedin') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Summary -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-envelope text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Email</p>
                                    <p class="text-sm text-gray-600">{{ $email ?: 'Not set' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-phone text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Phone</p>
                                    <p class="text-sm text-gray-600">{{ $phone_number ?: 'Not set' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-globe text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Website</p>
                                    <p class="text-sm text-gray-600">{{ $website ?: 'Not set' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-red-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Address</p>
                                    <p class="text-sm text-gray-600">{{ $address ? Str::limit($address, 50) : 'Not set' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-8 border-t border-gray-200">
                    <button 
                        type="button" 
                        wire:click="resetForm"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                    >
                        <i class="fas fa-undo mr-2"></i>
                        Reset Changes
                    </button>
                    
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>
                            <i class="fas fa-save mr-2"></i>
                            Save Changes
                        </span>
                        <span wire:loading>
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Saving...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div wire:loading.flex class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
            <svg class="animate-spin h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-900 font-medium">Processing...</span>
        </div>
    </div>

<!-- TinyMCE Editor Integration -->

{{-- TinyMCE CDN with your API key --}}
<script src="https://cdn.tiny.cloud/1/to56akp6ay2eqwul1pcclvaz04sti76oxkmrl8tllpna0k5m/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    document.addEventListener('livewire:init', function() {
        // Initialize TinyMCE for all rich editors
        initRichEditors();

        // When Livewire updates DOM
        Livewire.hook('morph.updated', (message, component) => {
            initRichEditors();
        });

        function initRichEditors() {
            if (document.querySelector('.rich-editor')) {
                tinymce.remove('.rich-editor');

                tinymce.init({
                    selector: '.rich-editor',
                    height: 400,
                    menubar: false,
                    branding: false,
                    plugins: [
                        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                        'insertdatetime', 'media', 'table', 'help', 'wordcount'
                    ],
                    toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                    block_formats: 'Paragraph=p; Header 1=h1; Header 2=h2; Header 3=h3; Header 4=h4; Header 5=h5; Header 6=h6;',
                    content_style: `
                        body {
                            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
                            font-size: 14px;
                            line-height: 1.6;
                            color: #374151;
                        }
                        h1, h2, h3, h4, h5, h6 {
                            color: #111827;
                            margin-top: 1em;
                            margin-bottom: 0.5em;
                        }
                        p { margin-bottom: 1em; }
                        ul, ol { margin-bottom: 1em; padding-left: 1.5em; }
                    `,
                    skin: 'oxide',
                    content_css: 'default',
                    setup: function(editor) {
                        editor.on('change blur keyup paste', function(e) {
                            const wireModel = editor.targetElm.getAttribute('wire:model');
                            if (wireModel) {
                                clearTimeout(editor._timeout);
                                editor._timeout = setTimeout(function () {
                                    @this.set(wireModel, editor.getContent());
                                }, 300);
                            }
                        });
                    }
                });
            }
        }

        Livewire.on('clearMessage', () => {
            setTimeout(function() {
                @this.set('success', false);
            }, 5000);
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.transition = 'opacity 0.5s ease-out';
                successMessage.style.opacity = '0';
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 500);
            }, 5000);
        }
    });
</script>



<!-- Initialize TinyMCE -->
<script>
  tinymce.init({
    selector: 'textarea.rich-editor',
    plugins: [
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
  });
</script>




<!-- Custom CSS for better styling -->
<style>
    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
        color: #111827;
        font-weight: 600;
    }
    
    .prose p {
        color: #374151;
        margin-bottom: 1em;
    }
    
    .prose ul, .prose ol {
        color: #374151;
    }
    
    .prose strong {
        color: #111827;
        font-weight: 600;
    }
    
    .prose a {
        color: #2563eb;
        text-decoration: underline;
    }
    
    .prose a:hover {
        color: #1d4ed8;
    }

    /* Smooth transitions for tab switching */
    .tab-content {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Custom scrollbar for better UX */
    .overflow-y-auto::-webkit-scrollbar {
        width: 6px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>


</div>