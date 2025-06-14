@extends('layouts.app')
@section('main-content')


    <div class=" flex  mt-2 flex-col">
        <!-- Breadcrumb navigation -->
        <div class="bg-white px-6 py-1 shadow-sm">
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
           

            <livewire:backend.components.hub.hub-overview />


             <!-- Header -->
             <div class="flex mt-6 justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">All Hubs</h1>
                <button id="openModalBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Add New Hub
                </button>
            </div>


           <livewire:backend.components.hub.hub-list-table  />



        </main>
    </div>

   







    <style>
        .sidebar-modal {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            max-width: 450px;
            height: 100vh;
            background-color: white;
            transition: right 0.3s ease-in-out;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 50;
            overflow-y: auto;
        }
        
        .sidebar-modal.open {
            right: 0;
        }
        
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease;
            z-index: 40;
        }
        
        .modal-overlay.open {
            opacity: 1;
            visibility: visible;
        }
        
        body.modal-open {
            overflow: hidden;
        }
    </style>
    <!-- Trigger Button -->
   
    
    <!-- Modal Overlay -->
    <div id="modalOverlay" class="modal-overlay"></div>
    
    <!-- Sidebar Modal -->
    <div id="sidebarModal" class="sidebar-modal">
        <div class="p-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Register Hub</h2>
                <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>
            
         
            <livewire:backend.components.hub.add-hub />



        </div>
    </div>
    
    <script>
        // Get DOM elements
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const sidebarModal = document.getElementById('sidebarModal');
        const modalOverlay = document.getElementById('modalOverlay');
        
        // Open modal function
        function openModal() {
            sidebarModal.classList.add('open');
            modalOverlay.classList.add('open');
            document.body.classList.add('modal-open');
        }
        
        // Close modal function
        function closeModal() {
            sidebarModal.classList.remove('open');
            modalOverlay.classList.remove('open');
            document.body.classList.remove('modal-open');
        }
        
        // Event listeners
        openModalBtn.addEventListener('click', openModal);
        closeModalBtn.addEventListener('click', closeModal);
        modalOverlay.addEventListener('click', closeModal);
        
        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebarModal.classList.contains('open')) {
                closeModal();
            }
        });
    </script>

@endsection