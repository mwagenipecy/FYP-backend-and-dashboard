<div>
<div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Hub Settings</h1>
            <p class="text-gray-600">Manage the details and information for {{ $hub->name }}</p>
        </div>

        <!-- Success Message -->
        @if($success)
        <div id="success-message" class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">Hub details updated successfully!</span>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('success-message').style.display = 'none';
            }, 3000);
        </script>
        @endif

        <form wire:submit.prevent="saveHub" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Hub Image -->
                <div class="col-span-1 md:col-span-2 flex flex-col items-center">
                    <div class="w-32 h-32 mb-4 overflow-hidden rounded-full">
                        @if($image && !$newImage)
                            <img src="{{ asset($image) }}" alt="{{ $name }}" class="w-full h-full object-cover">
                        @elseif($newImage)
                            <img src="{{ $newImage->temporaryUrl() }}" alt="New Image" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif
                    </div>
                    <label for="newImage" class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Change Image
                    </label>
                    <input id="newImage" type="file" wire:model="newImage" class="hidden" accept="image/*">
                    @error('newImage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Hub Name</label>
                    <input type="text" id="name" wire:model="name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" wire:model="email" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="text" id="phone_number" wire:model="phone_number" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('phone_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" wire:model="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Address -->
                <div class="col-span-1 md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" id="address" wire:model="address" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="col-span-1 md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="description" wire:model="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Rich Text Editors -->
                <!-- About Section -->
                <div class="col-span-1 md:col-span-2">
                    <div class="mb-2 flex justify-between items-center">
                        <label class="block text-sm font-medium text-gray-700">About</label>
                        <button 
                            type="button" 
                            wire:click="setActiveEditor('about')" 
                            class="text-blue-600 hover:text-blue-800"
                        >
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </div>
                    
                    @if($activeEditor === 'about')
                        <div class="border border-blue-300 rounded-md p-2 bg-blue-50">
                            <div wire:ignore>
                                <textarea 
                                    id="about-editor" 
                                    wire:model="about" 
                                    class="w-full rich-editor"
                                >{{ $about }}</textarea>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-gray-50 rounded-md prose max-w-none">
                            {!! $about !!}
                        </div>
                    @endif
                    @error('about') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Mission Section -->
                <div class="col-span-1 md:col-span-2">
                    <div class="mb-2 flex justify-between items-center">
                        <label class="block text-sm font-medium text-gray-700">Mission</label>
                        <button 
                            type="button" 
                            wire:click="setActiveEditor('mission')" 
                            class="text-blue-600 hover:text-blue-800"
                        >
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </div>
                    
                    @if($activeEditor === 'mission')
                        <div class="border border-blue-300 rounded-md p-2 bg-blue-50">
                            <div wire:ignore>
                                <textarea 
                                    id="mission-editor" 
                                    wire:model="mission" 
                                    class="w-full rich-editor"
                                >{{ $mission }}</textarea>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-gray-50 rounded-md prose max-w-none">
                            {!! $mission !!}
                        </div>
                    @endif
                    @error('mission') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Vision Section -->
                <div class="col-span-1 md:col-span-2">
                    <div class="mb-2 flex justify-between items-center">
                        <label class="block text-sm font-medium text-gray-700">Vision</label>
                        <button 
                            type="button" 
                            wire:click="setActiveEditor('vision')" 
                            class="text-blue-600 hover:text-blue-800"
                        >
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </div>
                    
                    @if($activeEditor === 'vision')
                        <div class="border border-blue-300 rounded-md p-2 bg-blue-50">
                            <div wire:ignore>
                                <textarea 
                                    id="vision-editor" 
                                    wire:model="vision" 
                                    class="w-full rich-editor"
                                >{{ $vision }}</textarea>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-gray-50 rounded-md prose max-w-none">
                            {!! $vision !!}
                        </div>
                    @endif
                    @error('vision') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- TinyMCE Editor Integration -->
    @push('scripts')
    <script src="https://cdn.tiny.cloud/1/your-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            // Initialize TinyMCE for all rich editors
            initRichEditors();
            
            // When Livewire is updated and a new editor is shown
            Livewire.hook('message.processed', (message, component) => {
                initRichEditors();
            });
            
            // Initialize editor function
            function initRichEditors() {
                if (document.querySelector('.rich-editor')) {
                    tinymce.remove('.rich-editor'); // Remove any existing instances
                    
                    tinymce.init({
                        selector: '.rich-editor',
                        height: 300,
                        menubar: false,
                        plugins: [
                            'advlist autolink lists link image charmap print preview anchor',
                            'searchreplace visualblocks code fullscreen',
                            'insertdatetime media table paste code help wordcount'
                        ],
                        toolbar: 'undo redo | formatselect | ' +
                        'bold italic backcolor | alignleft aligncenter ' +
                        'alignright alignjustify | bullist numlist outdent indent | ' +
                        'removeformat | help',
                        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                        setup: function(editor) {
                            // Update Livewire model when editor changes
                            editor.on('change', function(e) {
                                @this.set(editor.targetElm.getAttribute('wire:model'), editor.getContent());
                            });
                            
                            // Also update on blur, keyup events
                            editor.on('blur', function(e) {
                                @this.set(editor.targetElm.getAttribute('wire:model'), editor.getContent());
                            });
                            
                            editor.on('keyup', function(e) {
                                @this.set(editor.targetElm.getAttribute('wire:model'), editor.getContent());
                            });
                        }
                    });
                }
            }
            
            // Clear success message after 3 seconds
            window.addEventListener('clearMessage', event => {
                setTimeout(function() {
                    @this.set('success', false);
                }, 3000);
            });
        });
    </script>
    @endpush
</div>

</div>
