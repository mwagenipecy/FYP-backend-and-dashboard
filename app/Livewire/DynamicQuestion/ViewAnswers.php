<?php

namespace App\Livewire\DynamicQuestion;


use App\Models\QuestionAnswer;
use App\Models\DynamicQuestion;
use Livewire\Component;
use Livewire\WithPagination;

class ViewAnswers extends Component
{
    use WithPagination;

    public $selectedQuestion = 'all';
    public $searchEmail = '';

    public function updatingSearchEmail()
    {
        $this->resetPage();
    }

    public function updatingSelectedQuestion()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = QuestionAnswer::with('question')
            ->latest('answered_at');

        if ($this->selectedQuestion !== 'all') {
            $query->where('question_id', $this->selectedQuestion);
        }

        if ($this->searchEmail) {
            $query->where('student_email', 'like', '%' . $this->searchEmail . '%');
        }

        return view('livewire.dynamic-question.view-answers', [
            'answers' => $query->paginate(15),
            'questions' => DynamicQuestion::ordered()->get(),
        ]);
    }
}





