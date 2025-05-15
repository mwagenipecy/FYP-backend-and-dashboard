<div>
    {{-- Success is as dangerous as failure. --}}

    <nav class="px-2 py-2 space-y-1">
         <!-- Dashboard -->
<a href="{{ route('individual.project.list', session('project')->id) }}" 
   class="group flex items-center px-3 py-2 text-base font-medium rounded-lg 
          {{ request()->routeIs('individual.project.list') ? 'bg-white text-blue-700 shadow-md' : 'text-white hover:bg-white/20 transition duration-150' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('individual.project.list') ? 'text-blue-600' : 'text-blue-200 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
    </svg>
    Dashboard
</a>

<!-- Documents -->
<a href="{{ route('document.list') }}" 
   class="group flex items-center px-3 py-2 text-base font-medium rounded-lg 
          {{ request()->routeIs('document.list') ? 'bg-white text-blue-700 shadow-md' : 'text-white hover:bg-white/20 transition duration-150' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('document.list') ? 'text-blue-600' : 'text-blue-200 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    </svg>
    Documents
</a>

<!-- Phases -->
<a href="{{ route('project.phases', session('project')->id) }}" 
   class="group flex items-center px-3 py-2 text-base font-medium rounded-lg 
          {{ request()->routeIs('project.phases') ? 'bg-white text-blue-700 shadow-md' : 'text-white hover:bg-white/20 transition duration-150' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('project.phases') ? 'text-blue-600' : 'text-blue-200 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
    </svg>
    Phases
</a>

            
            <!-- <a href="#" class="group flex items-center px-3 py-2 text-base font-medium rounded-lg text-white hover:bg-white/20 transition duration-150">
                <svg class="mr-3 h-5 w-5 text-blue-200 group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
                Updates
            </a> -->


           <!-- Members -->
<a href="{{ route('project.users', session('project')->id) }}" 
   class="group flex items-center px-3 py-2 text-base font-medium rounded-lg 
          {{ request()->routeIs('project.users') ? 'bg-white text-blue-700 shadow-md' : 'text-white hover:bg-white/20 transition duration-150' }}">
    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('project.users') ? 'text-blue-600' : 'text-blue-200 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20h5v-2a4 4 0 00-4-4H9m4-4a4 4 0 100-8 4 4 0 000 8zm6 4a4 4 0 100-8 4 4 0 000 8z" />
    </svg>
    Members
</a>




        </nav>


</div>
