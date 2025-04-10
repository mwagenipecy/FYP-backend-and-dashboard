<?php

namespace App\Livewire\Files;

use Livewire\Component;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

class DocumentListing extends Component
{
    public $currentPath = 'users-files';
    public $documents = [];

    public $showDeleteDocumentModal = false;
    public $documentToDelete = null;

    protected $listeners = ['folderChanged' => 'updateCurrentPath', 'documentCreated' => 'loadDocuments'];

    public function mount($initialPath = 'users-files')
    {
        $this->currentPath = $initialPath;
        $this->loadDocuments();
    }

    public function updateCurrentPath($newPath)
    {
        $this->currentPath = $newPath;
        $this->loadDocuments();
    }

    public function loadDocuments()
    {
        $files = Storage::files($this->currentPath);
        $this->documents = collect($files)->map(function ($file) {
            return [
                'name' => basename($file),
                'size' => $this->formatSize(Storage::size($file)),
                'date' => Storage::lastModified($file),
                'preview_url' => $this->getPreviewUrl($file),
            ];
        })->toArray();
    }

    private function getPreviewUrl($file)
    {
        // Generate a signed URL that expires in 1 hour
        return URL::temporarySignedRoute(
            'document.preview',
            now()->addHour(),
            ['path' => $file]
        );
    }

    private function formatSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    public function deleteFileOld($fileName)
    {
        Storage::delete($this->currentPath . '/' . $fileName);
        $this->loadDocuments();
    }

    public function deleteFile($fileName)
    {
        $this->documentToDelete = $fileName;
        $this->showDeleteDocumentModal = true;
    }

    public function confirmDeleteFile()
    {
        Storage::delete($this->currentPath . '/' . $this->documentToDelete);
        $this->loadDocuments();
        $this->showDeleteDocumentModal = false;
        $this->documentToDelete = null;
    }

    public function downloadFile($fileName)
    {
        return Storage::download($this->currentPath . '/' . $fileName);
    }

    public function openCreateDocumentModal()
    {
        $this->dispatch('openCreateDocumentModal', $this->currentPath);
    }

    public function render()
    {
        return view('livewire.files.document-listing');
    }
}
