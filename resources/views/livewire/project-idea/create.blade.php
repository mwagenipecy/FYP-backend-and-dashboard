<div>
    {{-- Project Idea Submission Form --}}

    <form wire:submit.prevent="submit">
        <!-- Title -->
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">
                Title <span class="text-red-500">*</span>
            </label>
            <input type="text" id="title" wire:model.defer="title"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   placeholder="Enter project title">
            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Idea Type -->
        <div class="mb-4">
            <label for="idea_type" class="block text-sm font-medium text-gray-700">
                Idea Type <span class="text-red-500">*</span>
            </label>
            <select id="idea_type" wire:model.defer="idea_type"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Select Type</option>
                <option value="technology">Technology</option>
                <option value="iot">IoT</option>
                <option value="health">Health</option>
                <option value="education">Education</option>
                <option value="agriculture">Agriculture</option>
                <option value="energy">Energy</option>
            </select>
            @error('idea_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700">
                Description <span class="text-red-500">*</span>
            </label>
            <textarea id="description" wire:model.defer="description" rows="5"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                      placeholder="Describe your project idea in detail"></textarea>
            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Submit Idea
            </button>
        </div>
    </form>
</div>
