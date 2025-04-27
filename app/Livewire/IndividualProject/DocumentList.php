<?php

namespace App\Livewire\IndividualProject;

use Livewire\Component;
use App\Models\Document ;
use App\Models\Hub;
use App\Models\Stage;
use Livewire\WithPagination;
class DocumentList extends Component
{


    use WithPagination;

    public $search = '';
    public $hub_id = '';
    public $stage_id = '';
    
    protected $queryString = [
        'search' => ['except' => ''],
        'hub_id' => ['except' => ''],
        'stage_id' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Document::query()
            ->with(['hub', 'stage', 'uploader', 'approver'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('file_name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->hub_id, function ($query) {
                $query->where('hub_id', $this->hub_id);
            })
            ->when($this->stage_id, function ($query) {
                $query->where('stage_id', $this->stage_id);
            })
            ->latest();

        $documents = $query->paginate(10);
        $hubs = Hub::all();
        $stages = Stage::all();

        return view('livewire.individual-project.document-list', [
            'documents' => $documents,
            'hubs' => $hubs,
            'stages' => $stages,
        ]);
    }

    public function approve($documentId)
    {
        $document = Document::findOrFail($documentId);
        $document->is_approved = true;
        $document->approved_by = auth()->id();
        $document->approved_at = now();
        $document->save();

        session()->flash('message', 'Document approved successfully.');
    }

    public function delete($documentId)
    {
        $document = Document::findOrFail($documentId);
        $document->delete();

        session()->flash('message', 'Document deleted successfully.');
    }



  
}
