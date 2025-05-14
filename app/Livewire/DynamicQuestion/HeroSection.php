<?php

namespace App\Livewire\DynamicQuestion;

use App\Models\DynamicQuestion;
use Livewire\Component;

class HeroSection extends Component
{
    public $totalQuestions;
    public $estimatedTime;
    public $applicationDeadline = null;

    public function mount()
    {
        $this->totalQuestions = DynamicQuestion::count();
        $this->estimatedTime = $this->calculateEstimatedTime();
        // You can set a deadline if needed
        // $this->applicationDeadline = now()->addDays(30);
    }

    private function calculateEstimatedTime()
    {
        // Estimate 1 minute per question on average
        $minutes = $this->totalQuestions * 1;
        
        if ($minutes < 5) {
            return "Less than 5 minutes";
        } elseif ($minutes < 10) {
            return "5-10 minutes";
        } elseif ($minutes < 15) {
            return "10-15 minutes";
        } else {
            return "About " . ceil($minutes / 5) * 5 . " minutes";
        }
    }

    public function render()
    {
        return view('livewire.dynamic-question.hero-section');
    }
}


