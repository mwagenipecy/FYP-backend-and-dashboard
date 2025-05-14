@extends('layouts.app')

@section('main-content')


<livewire:backend.onboarding.over-view />

<livewire:dynamic-question.answer-questions />

<livewire:dynamic-question.question-builder />

<livewire:dynamic-question.view-answers />

@endsection