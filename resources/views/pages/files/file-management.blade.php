@extends('layouts.app')
@section('page')
    <div class="flex items-center justify-between">
        <h2 class="my-4 text-xl font-semibold leading-none tracking-tight text-gray-900 md:text-4xl dark:text-white">
            Documents Management
        </h2>
        {{-- <div class="space-x-2">
            <!-- Button to open Upload Document modal -->
            <button type="button"
                data-drawer-target="uploadDocument"
                data-drawer-show="uploadDocument"
                aria-controls="uploadDocument"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:ring-4 focus:ring-blue-300">
                Upload
            </button>
        </div> --}}
    </div>

    @livewire('files.folder-listing')

    @livewire('files.document-listing')
@endsection
