<div>
    <!-- Breadcrumb Navigation -->
    <div class="mb-4">
        <nav class="flex items-center text-sm">
            @foreach ($breadcrumb as $key => $crumb)
                @if ($key != count($breadcrumb) - 1)
                    <a href="#" wire:click.prevent="navigateTo({{ $key }})"
                        class="text-blue-500 hover:underline">
                        {{ $crumb }}
                    </a>
                    <span class="mx-2 text-gray-500">/</span>
                @else
                    <span class="text-gray-500">{{ $crumb }}</span>
                @endif
            @endforeach
        </nav>
    </div>

    <!-- Folder Listing -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
        @forelse($folders as $folder)
            <div class="bg-blue-100 p-4 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div class="flex items-center cursor-pointer" wire:click="openFolder('{{ $folder['path'] }}')">
                        <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        <span class="font-semibold">{{ $folder['name'] }}</span>
                    </div>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                </path>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                            <a href="#" wire:click="editFolder('{{ $folder['name'] }}')"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Rename</a>
                            <a href="#" wire:click.prevent="deleteFolder('{{ $folder['name'] }}')"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Delete</a>
                            <a href="#" wire:click="toggleFolderVisibility('{{ $folder['path'] }}')"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ $folder['visible'] ? 'Hide' : 'Show' }}
                            </a>
                        </div>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mt-2">{{ $folder['files'] }} Files · {{ $folder['size'] }}</p>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-gray-100 p-4 rounded-lg shadow text-center">
                    <p class="text-gray-500">No folders found. Create a new folder to get started.</p>
                </div>
            </div>
        @endforelse
    </div>


    <div class="mt-4">
        <button wire:click="$set('showCreateFolderModal', true)" class="bg-blue-500 text-white px-4 py-2 rounded">Create
            New Folder</button>
    </div>

    <!-- Create Folder Modal -->
    @include('livewire.files.partials.create-folder-modal')

    <!-- Delete Folder Modal -->
    @include('livewire.files.partials.delete-folder-modal')
</div>
