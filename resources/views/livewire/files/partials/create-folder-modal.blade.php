<div id="createFolderModal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50  bg-gray-100 bg-opacity-50  w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
        style="display: {{ $showCreateFolderModal ? 'block' : 'none' }};">


        <div class="flex justify-center item-center">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow xy:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t xy:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 xy:text-white">
                        {{ $isEditMode ? 'Edit Folder' : 'Create New Folder' }}
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center xy:hover:bg-gray-600 xy:hover:text-white"
                        wire:click="resetModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form wire:submit.prevent="createOrEditFolder">
                        <div class="mb-4">
                            <label for="newFolderName" class="block text-sm font-medium text-gray-700">Folder
                                Name</label>
                            <input type="text" id="newFolderName" wire:model="newFolderName"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2"
                                wire:click="resetModal">Cancel</button>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded">{{ $isEditMode ? 'Update Folder' : 'Create Folder' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>


    </div>
