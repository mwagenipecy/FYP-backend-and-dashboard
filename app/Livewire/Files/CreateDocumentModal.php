<?php

namespace App\Livewire\Files;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CreateDocumentModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $uploadedFile;
    public $folders = [];
    public $selectedFolder = '';
    public $currentPath = 'users-files';

    protected $listeners = ['openCreateDocumentModal' => 'openModal', 'folderChanged' => 'updateCurrentPath'];

    protected $rules = [
        'uploadedFile' => 'required|file|max:2048', // 2MB Max
        'selectedFolder' => 'nullable|string'
    ];

    public function mount()
    {
        $this->loadFolders();
    }

    public function openModal($path)
    {
        $this->currentPath = $path;
        $this->loadFolders();
        $this->showModal = true;
    }

    public function updateCurrentPath($newPath)
    {
        $this->currentPath = $newPath;
        $this->loadFolders();
    }

    public function loadFolders()
    {
        $this->folders = $this->getNestedFolders($this->currentPath);
        $this->selectedFolder = $this->currentPath;
    }

    private function getNestedFolders($path, $prefix = '')
    {
        $folders = [];
        $directories = Storage::directories($path);

        foreach ($directories as $directory) {
            $relativePath = $directory;
            $folderName = $prefix . basename($directory);
            $folders[$relativePath] = $folderName;

            // Recursively get subfolders
            $subFolders = $this->getNestedFolders($directory, $folderName . ' / ');
            $folders = array_merge($folders, $subFolders);
        }

        return $folders;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['uploadedFile', 'selectedFolder']);
    }

    public function updatedUploadedFile()
    {
        $this->validateOnly('uploadedFile');
    }

    public function createDocument()
    {
        $this->validate();

        $folderPath = $this->selectedFolder ?: $this->currentPath;

        if ($this->uploadedFile) {
            $fileName = $this->uploadedFile->getClientOriginalName();
            $this->uploadedFile->storeAs($folderPath, $fileName);

            $this->closeModal();
            $this->dispatch('documentCreated');
        }
    }

    public function render()
    {
        return view('livewire.files.create-document-modal');
    }
}
