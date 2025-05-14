<?php

namespace App\Livewire\DynamicQuestion;

use App\Models\DynamicQuestion;
use App\Models\QuestionAnswer;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class AnswerQuestions extends Component
{
    use WithFileUploads;

    public $studentName = '';
    public $studentEmail = '';
    public $answers = [];
    public $files = [];
    public $currentStep = 1;
    public $totalSteps;
    public $questions;
    public $isSubmitted = false;

    protected $rules = [
        'studentName' => 'required|min:2',
        'studentEmail' => 'required|email',
    ];

    public function mount()
    {
        $this->questions = DynamicQuestion::ordered()->get();
        $this->totalSteps = $this->questions->count() + 1; // +1 for student info step

        // Initialize answers and files arrays
        foreach ($this->questions as $question) {
            $this->answers[$question->id] = $question->type === 'checkbox' ? [] : '';
            $this->files[$question->id] = [];
        }

        // Pre-fill if user is authenticated
        if (auth()->check()) {
            $this->studentName = auth()->user()->name;
            $this->studentEmail = auth()->user()->email;
        }
    }

    public function nextStep()
    {
        $this->validateCurrentStep();
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function validateCurrentStep()
    {
        if ($this->currentStep === 1) {
            // Validate student info
            $this->validate();
            return;
        }

        // Validate current question
        $currentQuestionIndex = $this->currentStep - 2;
        $currentQuestion = $this->questions->get($currentQuestionIndex);
        
        if ($currentQuestion && $currentQuestion->required) {
            $rules = [];
            
            if ($currentQuestion->type === 'file') {
                $rules["files.{$currentQuestion->id}"] = 'required|array|min:1';
                $rules["files.{$currentQuestion->id}.*"] = 'file|max:10240'; // 10MB max
            } else {
                $rules["answers.{$currentQuestion->id}"] = 'required';
            }
            
            $this->validate($rules, [
                "answers.{$currentQuestion->id}.required" => 'This question is required.',
                "files.{$currentQuestion->id}.required" => 'Please upload at least one file.',
            ]);
        }
    }

    public function removeFile($questionId, $index)
    {
        if (isset($this->files[$questionId][$index])) {
            unset($this->files[$questionId][$index]);
            $this->files[$questionId] = array_values($this->files[$questionId]);
        }
    }

    public function submitAnswers()
    {
        // Validate all steps
        $this->validate();
        
        // Validate all required questions
        foreach ($this->questions as $question) {
            if ($question->required) {
                if ($question->type === 'file') {
                    $this->validate([
                        "files.{$question->id}" => 'required|array|min:1'
                    ], [
                        "files.{$question->id}.required" => "Question '{$question->question}' is required."
                    ]);
                } else {
                    $this->validate([
                        "answers.{$question->id}" => 'required'
                    ], [
                        "answers.{$question->id}.required" => "Question '{$question->question}' is required."
                    ]);
                }
            }
        }

        // Save all answers
        foreach ($this->questions as $question) {
            $answerData = [
                'question_id' => $question->id,
                'student_name' => $this->studentName,
                'student_email' => $this->studentEmail,
                'answered_at' => now(),
            ];

            if ($question->type === 'file' && isset($this->files[$question->id]) && count($this->files[$question->id]) > 0) {
                // Handle file uploads
                $filePaths = [];
                foreach ($this->files[$question->id] as $file) {
                    $path = $file->store("question-answers/{$question->id}", 'public');
                    $filePaths[] = $path;
                }
                $answerData['file_paths'] = $filePaths;
            } else {
                // Handle text answers
                $answer = $this->answers[$question->id] ?? '';
                if (is_array($answer)) {
                    $answer = json_encode($answer);
                }
                $answerData['answer'] = $answer;
            }

            // Only save if there's an answer or files
            if (!empty($answerData['answer']) || !empty($answerData['file_paths'])) {
                QuestionAnswer::create($answerData);
            }
        }

        $this->isSubmitted = true;
        session()->flash('message', 'Your answers have been submitted successfully!');
    }

    public function getCurrentQuestion()
    {
        if ($this->currentStep === 1 || $this->currentStep > $this->totalSteps) {
            return null;
        }

        $questionIndex = $this->currentStep - 2;
        return $this->questions->get($questionIndex);
    }

    public function getProgressPercentage()
    {
        return round(($this->currentStep / $this->totalSteps) * 100);
    }

    public function resetForm()
    {
        $this->currentStep = 1;
        $this->studentName = '';
        $this->studentEmail = '';
        $this->answers = [];
        $this->files = [];
        $this->isSubmitted = false;
        
        // Re-initialize arrays
        foreach ($this->questions as $question) {
            $this->answers[$question->id] = $question->type === 'checkbox' ? [] : '';
            $this->files[$question->id] = [];
        }
    }

    public function render()
    {
        return view('livewire.dynamic-question.answer-questions', [
            'currentQuestion' => $this->getCurrentQuestion(),
            'progressPercentage' => $this->getProgressPercentage(),
        ]);
    }
}

