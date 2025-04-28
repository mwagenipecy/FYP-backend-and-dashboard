<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management Portal</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles

    {{-- <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    @yield('styles')
    
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: true }">
    <div class="h-screen flex overflow-hidden">
        <!-- Sidebar -->
        <div x-data="{ sidebarOpen: true }" :class="{'hidden': !sidebarOpen, 'flex': sidebarOpen}" class="bg-gradient-to-b from-blue-600 to-blue-800 text-white w-64 flex-shrink-0 flex flex-col shadow-lg">
    <!-- Header -->
        <div class="h-16 flex items-center justify-between px-4 border-b border-blue-500/30 bg-white/10 backdrop-blur-sm">
            <span class="font-medium text-lg text-white">Project Management</span>
            <button @click="sidebarOpen = false" class="md:hidden rounded-md p-2 text-white/70 hover:text-white hover:bg-white/10 transition duration-150">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>



    
    <!-- Scrollable content -->
    <div class="flex-1 overflow-y-auto">
        <!-- Project info -->
        <div class="px-4 py-6 bg-white/5">
            <h2 class="text-xs font-semibold text-blue-100 uppercase tracking-wider"> {{ optional(session('project')->idea)->idea_type }} </h2>
            <div class="mt-2">
                <div class="flex items-center text-sm text-blue-100">
                    <span class="inline-block w-2 h-2 rounded-full bg-green-400 mr-2"></span>
                    <span>{{ session('project')->status }}</span>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
       

        <livewire:project.component.side-bar />



    </div>



    
    

    <livewire:project.component.footer />


  

</div>
        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
           
            <livewire:project.component.nav-bar />

           <!-- Main content area -->
           <main class="flex-1 overflow-y-auto bg-gray-50 p-6">


               
            @yield('project')



                 </main>
            </div>
            </div>


  <!-- Alert Scripts -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Chart Scripts -->
<script src="{{ asset('js/apexcharts.js') }}"></script>
 <script src="{{ asset('js/flowbite.min.js') }}"></script> 


</body>
</html>