<?php

namespace App\Livewire\IndividualProject;

use App\Models\Document;
use Livewire\Component;
class DocumentView extends Component
{

    public $document;
    public $documentId;

    protected $listeners = ['refreshDocument' => '$refresh'];

    public function mount($documentId)
    {
        $this->documentId = $documentId;
        $this->loadDocument();
    }

    public function loadDocument()
    {
        $this->document = Document::with(['hub', 'stage', 'uploader', 'approver'])
            ->findOrFail($this->documentId);
    }

    public function approve()
    {
        $this->document->is_approved = true;
        $this->document->approved_by = auth()->id();
        $this->document->approved_at = now();
        $this->document->save();

        session()->flash('message', 'Document approved successfully.');
        $this->loadDocument();
    }


    public function render()
    {
        return view('livewire.individual-project.document-view');
    }
}
