<?php

namespace App\Livewire\IndividualProject;

use Livewire\Component;
use App\Models\Document;
use App\Models\Hub;
use App\Models\Stage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class DocumentUpload extends Component
{

    use WithFileUploads;

    public $title;
    public $description;
    public $hub_id;
    public $stage_id;
    public $document;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'hub_id' => 'required|exists:hubs,id',
        'stage_id' => 'required|exists:stages,id',
        'document' => 'required|file|max:10240', // 10MB Max
    ];

    public function render()
    {
        $hubs = Hub::all();
        $stages = Stage::all();

        return view('livewire.individual-project.document-upload', [
            'hubs' => $hubs,
            'stages' => $stages,
        ]);
    }

    public function save()
    {
        $this->validate();



        try{


       
        $fileName = $this->document->getClientOriginalName();
        $fileType = $this->document->getClientMimeType();
        $fileSize = $this->document->getSize();
        $filePath = $this->document->store('documents', 'public');

        Document::create([
            'title' => $this->title,
            'description' => $this->description,
            'hub_id' => $this->hub_id,
            'stage_id' => $this->stage_id,
            'uploaded_by' => auth()->id(),
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_size' => $fileSize,
        ]);

        session()->flash('message', 'Document uploaded successfully!');
        $this->reset(['title', 'description', 'hub_id', 'stage_id', 'document']);
        $this->dispatch('documentUploaded');

    }
    catch(\Exception $e){

        dd($e->getMessage()
    );
    }
    }


}
