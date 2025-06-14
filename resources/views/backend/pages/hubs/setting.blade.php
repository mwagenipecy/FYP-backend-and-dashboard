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
             <div class="flex justify-between p-2"> 
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">All Hubs</h1>
                
            </div>



                <a href="{{ route('hub.summary',1) }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition duration-300 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                View Hub Info
                </a>

                </div>


          



            <livewire:backend.hub.setting :hubId="1" />


        </main>
    </div>

   








@endsection
