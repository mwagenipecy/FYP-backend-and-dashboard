<?php

namespace App\Livewire\DynamicQuestion;

use App\Models\DynamicQuestion;
use Livewire\Component;

class QuestionBuilder extends Component
{
    public $question = '';
    public $description = '';
    public $type = 'text';
    public $required = true;
    public $options = [];
    public $newOption = '';
    public $editingId = null;

    public $questionTypes = [
        'text' => 'Text Input',
        'textarea' => 'Textarea',
        'email' => 'Email',
        'date' => 'Date',
        'file' => 'File Upload',
        'radio' => 'Radio Buttons',
        'checkbox' => 'Checkboxes',
        'select' => 'Select Dropdown',
    ];

    protected $rules = [
        'question' => 'required|min:5',
        'type' => 'required|in:text,textarea,email,date,file,radio,checkbox,select',
        'required' => 'boolean',
    ];

    public function addOption()
    {
        if (trim($this->newOption) !== '') {
            $this->options[] = trim($this->newOption);
            $this->newOption = '';
        }
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function updatedType()
    {
        // Clear options when type changes and doesn't need options
        if (!in_array($this->type, ['radio', 'checkbox', 'select'])) {
            $this->options = [];
        }
    }

    public function save()
    {
        $this->validate();

        // Additional validation for option-based question types
        if (in_array($this->type, ['radio', 'checkbox', 'select'])) {
            $this->validate([
                'options' => 'required|array|min:2',
            ], [
                'options.required' => 'Please add at least 2 options for this question type.',
                'options.min' => 'Please add at least 2 options for this question type.',
            ]);
        }

        $data = [
            'question' => $this->question,
            'description' => $this->description,
            'type' => $this->type,
            'required' => $this->required,
            'options' => in_array($this->type, ['radio', 'checkbox', 'select']) ? $this->options : null,
        ];

        if ($this->editingId) {
            DynamicQuestion::find($this->editingId)->update($data);
            session()->flash('message', 'Question updated successfully!');
        } else {
            DynamicQuestion::create($data);
            session()->flash('message', 'Question created successfully!');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $question = DynamicQuestion::find($id);
        $this->editingId = $id;
        $this->question = $question->question;
        $this->description = $question->description;
        $this->type = $question->type;
        $this->required = $question->required;
        $this->options = $question->options ?? [];
    }

    public function delete($id)
    {
        DynamicQuestion::find($id)->delete();
        session()->flash('message', 'Question deleted successfully!');
    }

    public function resetForm()
    {
        $this->question = '';
        $this->description = '';
        $this->type = 'text';
        $this->required = true;
        $this->options = [];
        $this->newOption = '';
        $this->editingId = null;
    }

    public function reorder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            DynamicQuestion::where('id', $id)->update(['order' => $index + 1]);
        }
    }

    public function render()
    {
        return view('livewire.dynamic-question.question-builder', [
            'questions' => DynamicQuestion::ordered()->get(),
        ]);
    }
}



