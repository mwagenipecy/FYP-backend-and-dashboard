
@extends('layouts.main')
@section('layout')

    <div class="page-wrapper">
        <div class="body">

            @include('sections.sidebar')

            <main class="p-6 md:ml-64 h-auto pt-20">
                @yield('main-content')
                @yield('modals')
            </main>
        </div>
    </div>

@endsection
