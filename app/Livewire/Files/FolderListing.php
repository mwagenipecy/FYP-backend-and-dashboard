<?php

namespace App\Livewire\Files;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FolderListing extends Component
{
    use LivewireAlert;

    public $folders = [];
    public $currentPath = 'users-files';
    public $newFolderName = '';
    public $isEditMode = false;
    public $folderBeingEdited = null;
    public $showCreateFolderModal = false;
    public $breadcrumb = [];

    public $showDeleteFolderModal = false;
    public $folderToDelete = null;

    protected $listeners = ['documentCreated' => 'loadFolders'];

    public function mount()
    {
        $this->loadFolders();
        $this->updateBreadcrumb();
    }

    public function loadFolders()
    {
        $directories = Storage::directories($this->currentPath);
        $this->folders = collect($directories)->map(function ($directory) {
            $metadata = $this->getFolderMetadata($directory);
            return [
                'name' => basename($directory),
                'files' => $this->countFiles($directory),
                'size' => $this->getFolderSize($directory),
                'path' => $directory,
                'visible' => $metadata['visible'] ?? true,
            ];
        })->toArray();
    }

    private function getFolderMetadata($directory)
    {
        $metadataPath = $directory . '/.metadata.json';
        if (Storage::exists($metadataPath)) {
            return json_decode(Storage::get($metadataPath), true);
        }
        return [];
    }

    private function saveFolderMetadata($directory, $metadata)
    {
        $metadataPath = $directory . '/.metadata.json';
        Storage::put($metadataPath, json_encode($metadata));
    }

    private function countFiles($directory)
    {
        return count(Storage::files($directory));
    }

    private function getFolderSize($directory)
    {
        $files = Storage::allFiles($directory);
        $size = collect($files)->sum(function ($file) {
            return Storage::size($file);
        });
        return $this->formatSize($size);
    }

    private function formatSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    public function toggleFolderVisibility($folderPath)
    {
        $metadata = $this->getFolderMetadata($folderPath);
        $metadata['visible'] = !($metadata['visible'] ?? true);
        $this->saveFolderMetadata($folderPath, $metadata);
        $this->loadFolders();
    }

    public function createOrEditFolder()
    {
        $this->validate([
            'newFolderName' => 'required|min:1|max:255'
        ]);

        if ($this->isEditMode && $this->folderBeingEdited) {
            // Perform folder rename
            $oldPath = $this->currentPath . '/' . $this->folderBeingEdited;
            $newPath = $this->currentPath . '/' . $this->newFolderName;
            Storage::move($oldPath, $newPath);
        } else {
            // Create new folder
            Storage::makeDirectory($this->currentPath . '/' . $this->newFolderName);
        }

        $this->loadFolders();
        $this->resetModal();
    }

    public function editFolder($folderName)
    {
        $this->isEditMode = true;
        $this->folderBeingEdited = $folderName;
        $this->newFolderName = $folderName;
        $this->showCreateFolderModal = true;
    }

    public function resetModal()
    {
        $this->newFolderName = '';
        $this->isEditMode = false;
        $this->folderBeingEdited = null;
        $this->showCreateFolderModal = false;
    }

    public function deleteFolderOld($folderName)
    {
        Storage::deleteDirectory($this->currentPath . '/' . $folderName);
        $this->loadFolders();
    }

    public function deleteFolder($folderName)
    {
        $this->folderToDelete = $folderName;
        $this->showDeleteFolderModal = true;
    }

    public function confirmDeleteFolder()
    {
        // dd($this->folderToDelete);
        Storage::deleteDirectory($this->currentPath . '/' . $this->folderToDelete);
        $this->loadFolders();

        // Reset the state after deletion
        $this->showDeleteFolderModal = false;

        // Reset the folder name after deletion
        $this->folderToDelete = null;
    }

    public function openFolder($folderPath)
    {
        $this->currentPath = $folderPath;
        $this->loadFolders();
        $this->updateBreadcrumb();
        $this->dispatch('folderChanged', $this->currentPath);
    }

    public function updateBreadcrumb()
    {
        $this->breadcrumb = explode('/', $this->currentPath);
    }

    public function navigateTo($path)
    {
        $this->currentPath = implode('/', array_slice($this->breadcrumb, 0, $path + 1));
        $this->loadFolders();
        $this->updateBreadcrumb();
        $this->dispatch('folderChanged', $this->currentPath);
    }

    public function render()
    {
        return view('livewire.files.folder-listing');
    }
}
