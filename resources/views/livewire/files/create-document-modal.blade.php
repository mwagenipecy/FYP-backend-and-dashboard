<div>
    <div id="createDocumentModal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50  bg-gray-100 bg-opacity-50  w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
        style="display: {{ $showModal ? 'block' : 'none' }};">

        <div class="flex justify-center item-center">

            <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Create New Document
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        wire:click="closeModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form wire:submit.prevent="createDocument">
                        <!-- Folder Selection -->
                        <div class="mb-4">
                            <label for="folder" class="block text-sm font-medium text-gray-700">Select Folder</label>
                            <select id="folder" wire:model="selectedFolder" class="mt-1 block w-full">
                                <option value="{{ $currentPath }}">{{ basename($currentPath) }} (Current Folder)</option>
                                @foreach($folders as $path => $name)
                                    <option value="{{ $path }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('selectedFolder') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- File Upload -->
                        <div class="mb-4">
                            <label for="uploadedFile" class="block text-sm font-medium text-gray-700">Select File</label>
                            <div class="relative">
                                <input type="file" id="uploadedFile" wire:model="uploadedFile" class="mt-1 block w-full" required>
                                <button id="clearFile" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 hidden" onclick="clearFile()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Always visible progress bar -->
                            <div class="mt-2" id="fileProgressContainer">
                                <div class="relative pt-1">
                                    <div class="flex mb-2 items-center justify-between">
                                        <div>
                                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-teal-600 ">
                                                File Selection Progress
                                            </span>
                                        </div>
                                        <div class="text-right">
                                            <span id="fileProgressPercent" class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-teal-600 bg-teal-200">0%</span>
                                        </div>
                                    </div>
                                    <div class="flex mb-2">
                                        <div class="relative flex w-full flex-col">
                                            <div class="flex mb-2">
                                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                    <div id="fileProgressBar" class="bg-teal-500 h-2.5 rounded-full" style="width: 0;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Error message -->
                                <div id="uploadErrorMessage" class="mt-2 text-red-500 text-sm hidden">
                                    Failed to upload
                                </div>
                            </div>

                            @error('uploadedFile') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <script>
                            const fileInput = document.getElementById('uploadedFile');
                            const fileProgressContainer = document.getElementById('fileProgressContainer');
                            const fileProgressBar = document.getElementById('fileProgressBar');
                            const fileProgressPercent = document.getElementById('fileProgressPercent');
                            const clearFileButton = document.getElementById('clearFile');
                            const uploadErrorMessage = document.getElementById('uploadErrorMessage');

                            // Always show progress container (even if no file selected)
                            fileProgressContainer.style.display = 'block';

                            fileInput.addEventListener('change', function () {
                                const file = fileInput.files[0];

                                if (file) {
                                    // Show clear button
                                    clearFileButton.classList.remove('hidden');

                                    // Simulate file selection progress (just for demo)
                                    let progress = 0;
                                    let isValidFile = validateFile(file);  // Validate file type and size
                                    let interval = setInterval(() => {
                                        if (progress < 100) {
                                            progress += 2; // Simulate progress
                                            let percent = Math.min(progress, 100);
                                            fileProgressBar.style.width = percent + '%';
                                            fileProgressPercent.textContent = Math.round(percent) + '%';
                                        } else {
                                            clearInterval(interval);
                                            if (isValidFile) {
                                                fileProgressBar.classList.replace('bg-red-500', 'bg-green-500');
                                            } else {
                                                // Simulate file upload failure (set 60% progress and show error)
                                                fileProgressBar.classList.replace('bg-teal-500', 'bg-red-500');
                                                fileProgressBar.style.width = '60%';
                                                fileProgressPercent.textContent = '60%';
                                                uploadErrorMessage.style.display = 'block'; // Show error message
                                            }
                                        }
                                    }, 50);
                                }
                            });

                            function validateFile(file) {
                                const maxSize = 2 * 1024 * 1024; // Max file size: 5MB
                                const validTypes = ['*'];

                                if (file.size > maxSize ) {
                                    return false;
                                }
                                return true;
                            }

                            function clearFile() {
                                fileInput.value = '';  // Reset file input
                                fileProgressBar.style.width = '0';  // Reset progress bar width
                                fileProgressPercent.textContent = '0%';  // Reset progress percentage
                                fileProgressBar.classList.replace('bg-green-500', 'bg-teal-500');  // Reset to default color
                                fileProgressBar.classList.replace('bg-red-500', 'bg-teal-500');  // Reset to default color
                                uploadErrorMessage.style.display = 'none';  // Hide error message
                                clearFileButton.classList.add('hidden');  // Hide the clear button
                            }
                        </script>



                        <div class="flex justify-end">
                            <button type="button" class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2" wire:click="closeModal">Cancel</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Upload Document</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        </div>

    </div>
</div>
