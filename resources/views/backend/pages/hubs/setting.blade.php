@extends('layouts.app')
@section('main-content')


    <div class=" flex  mt-1 flex-col">
        <!-- Breadcrumb navigation -->
        <div class="bg-white px-2 py-4 shadow-sm">
            <div class="flex items-center space-x-2 text-gray-600">
                <a href="#" class="hover:text-blue-600">
                    <i class="fas fa-home"></i>
                    <span class="ml-1">Home</span>
                </a>
                <i class="fas fa-chevron-right text-xs text-gray-400"></i>
                <a href="#" class="hover:text-blue-600">Platform</a>
                <i class="fas fa-chevron-right text-xs text-gray-400"></i>
                <span class="text-gray-800">Hub-page</span>
            </div>
        </div>

        <!-- Main content -->
        <main class="flex-1 px-6 py-4">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">All Hubs</h1>
                
            </div>


          



            <livewire:backend.hub.setting :hubId="1" />


        </main>
    </div>

   








@endsection
