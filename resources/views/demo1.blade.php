<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        
        <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar-expanded {
            width: 250px;
            transition: width 0.3s ease;
        }
        .sidebar-collapsed {
            width: 64px;
            transition: width 0.3s ease;
        }
        .main-expanded {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }
        .main-collapsed {
            margin-left: 64px;
            transition: margin-left 0.3s ease;
        }
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        .submenu.show {
            max-height: 500px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Component -->
        <aside id="sidebar" class="sidebar-expanded bg-white border-r border-gray-200 fixed h-full shadow-sm z-10">
            <!-- Toggle Button and Logo -->
            <div class="p-4 flex items-center">
                <button id="toggleSidebar" class="p-1 text-gray-500 rounded-md hover:text-gray-900 mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <a href="#" class="flex items-center text-xl font-semibold sidebar-text">
                    <div class="bg-blue-600 rounded-full p-1 mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span>Flowbite</span>
                </a>
            </div>

            <!-- Sidebar Menu -->
            <div class="p-4 pt-0">
                <ul class="space-y-2">
                    <!-- Dashboard Menu Item -->
                    <li>
                        <button class="menu-toggle w-full flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                            </svg>
                            <span class="ml-3 sidebar-text">Dashboards</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto h-5 w-5 sidebar-text transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <ul class="submenu pl-10 pr-2 py-0 space-y-1">
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>Main Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>E-commerce</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>Analytics</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Pages Menu Item -->
                    <li>
                        <button class="menu-toggle w-full flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-3 sidebar-text">Pages</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto h-5 w-5 sidebar-text transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <ul class="submenu pl-10 pr-2 py-0 space-y-1">
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>Settings</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>Kanban</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- E-commerce Menu Item -->
                    <li>
                        <button class="menu-toggle w-full flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-3 sidebar-text">E-commerce</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto h-5 w-5 sidebar-text transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <ul class="submenu pl-10 pr-2 py-0 space-y-1">
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>Products</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>Billing</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>Invoice</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Users Menu Item -->
                    <li>
                        <button class="menu-toggle w-full flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg>
                            <span class="ml-3 sidebar-text">Users</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto h-5 w-5 sidebar-text transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <ul class="submenu pl-10 pr-2 py-0 space-y-1">
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>User List</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>New User</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>User Settings</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Support Menu Item -->
                    <li>
                        <button class="menu-toggle w-full flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-3 sidebar-text">Support</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto h-5 w-5 sidebar-text transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <ul class="submenu pl-10 pr-2 py-0 space-y-1">
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>Contact Us</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>Tickets</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>FAQ</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Status Pages Menu Item -->
                    <li>
                        <button class="menu-toggle w-full flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0c0 .993-.241 1.929-.668 2.754l-1.524-1.525a3.997 3.997 0 00.078-2.183l1.562-1.562C15.802 8.249 16 9.1 16 10zm-5.165 3.913l1.58 1.58A5.98 5.98 0 0110 16a5.976 5.976 0 01-2.516-.552l1.562-1.562a4.006 4.006 0 001.789.027zm-4.677-2.796a4.002 4.002 0 01-.041-2.08l-.08.08-1.53-1.533A5.98 5.98 0 004 10c0 .954.223 1.856.619 2.657l1.54-1.54zm1.088-6.45A5.974 5.974 0 0110 4c.954 0 1.856.223 2.657.619l-1.54 1.54a4.002 4.002 0 00-2.346.033L7.246 4.668zM12 10a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-3 sidebar-text">Status Pages</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto h-5 w-5 sidebar-text transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <ul class="submenu pl-10 pr-2 py-0 space-y-1">
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>404 Not Found</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>500 Server Error</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
                                    <span>Maintenance</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Content Area with Navbar -->
        <div id="mainContent" class="main-expanded flex-1 flex flex-col h-full overflow-y-auto bg-gray-50">
            <!-- Navbar -->
            <nav class="bg-white border-b border-gray-200 px-4 py-2.5 fixed left-0 right-0 top-0 z-50">
                <div class="flex flex-wrap justify-between items-center">
                    <!-- Left navbar (spacing for sidebar) -->
                    <div class="flex items-center justify-start">
                        <div class="w-64 sidebar-expanded-space"></div>
                        <!-- Logo for navbar, only visible when sidebar is collapsed -->
                        <a href="#" class="flex items-center ml-4 sidebar-collapsed-logo hidden">
                            <div class="bg-blue-600 rounded-full p-1 mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="self-center text-xl font-semibold whitespace-nowrap">Flowbite</span>
                        </a>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="flex-1 max-w-md mx-auto">
                        <div class="relative">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" id="search-navbar" class="block p-2 pl-10 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Search">
                        </div>
                    </div>

                    <!-- Right side icons -->
                    <div class="flex items-center space-x-3">
                        <button class="p-2 text-gray-500 rounded-lg hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </button>
                        <button class="p-2 text-gray-500 rounded-lg hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </button>
                        <button class="p-2 text-gray-500 rounded-lg hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                        </button>
                        <button class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300">
                            <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
                        </button>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="p-4 mt-16">
                <!-- Add your content here -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-xl font-bold mb-4">Welcome to the Dashboard</h2>
                    <p class="text-gray-600">Your content will appear here.</p>
                </div>
            </div>

            <!-- Footer -->
            <footer class="bg-white p-4 border-t border-gray-200 mt-auto">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">© 2025 Flowbite. All rights reserved.</span>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-500 hover:text-gray-900">Privacy Policy</a>
                        <a href="#" class="text-gray-500 hover:text-gray-900">API</a>
                        <a href="#" class="text-gray-500 hover:text-gray-900">Contact</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- JavaScript for the sidebar and submenu functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle functionality
            const toggleSidebarBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            const mainContent = document.getElementById('mainContent');
            const sidebarExpandedSpace = document.querySelector('.sidebar-expanded-space');
            const sidebarCollapsedLogo = document.querySelector('.sidebar-collapsed-logo');
            
            toggleSidebarBtn.addEventListener('click', function() {
                if (sidebar.classList.contains('sidebar-expanded')) {
                    // Collapse sidebar
                    sidebar.classList.remove('sidebar-expanded');
                    sidebar.classList.add('sidebar-collapsed');
                    mainContent.classList.remove('main-expanded');
                    mainContent.classList.add('main-collapsed');
                    
                    // Hide text in sidebar
                    sidebarTexts.forEach(text => {
                        text.classList.add('hidden');
                    });
                    
                    // Adjust spacing in navbar
                    sidebarExpandedSpace.classList.remove('w-64');
                    sidebarExpandedSpace.classList.add('w-16');
                    
                    // Show collapsed navbar logo
                    sidebarCollapsedLogo.classList.remove('hidden');
                    
                    // Hide all open submenus
                    document.querySelectorAll('.submenu.show').forEach(menu => {
                        menu.classList.remove('show');
                    });
                    
                    // Reset rotated arrows
                    document.querySelectorAll('.menu-toggle svg.rotate-180').forEach(arrow => {
                        arrow.classList.remove('rotate-180');
                    });
                } else {
                    // Expand sidebar
                    sidebar.classList.remove('sidebar-collapsed');
                    sidebar.classList.add('sidebar-expanded');
                    mainContent.classList.remove('main-collapsed');
                    mainContent.classList.add('main-expanded');
                    
                    // Show text in sidebar
                    sidebarTexts.forEach(text => {
                        text.classList.remove('hidden');
                    });
                    
                    // Adjust spacing in navbar
                    sidebarExpandedSpace.classList.remove('w-16');
                    sidebarExpandedSpace.classList.add('w-64');
                    
                    // Hide collapsed navbar logo
                    sidebarCollapsedLogo.classList.add('hidden');
                }
            });
            
            // Submenu toggle functionality
            const menuToggles = document.querySelectorAll('.menu-toggle');
            
            menuToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    // Only allow submenu toggling when sidebar is expanded
                    if (sidebar.classList.contains('sidebar-expanded')) {
                        const submenu = this.nextElementSibling;
                        
                        // Toggle this submenu
                        submenu.classList.toggle('show');
                        
                        // Toggle the arrow direction
                        const arrow = this.querySelector('svg:last-child');
                        arrow.classList.toggle('rotate-180');
                    }
                });
            });
            
            // Initialize sidebar state - start with expanded sidebar by default
            if (!sidebar.classList.contains('sidebar-expanded')) {
                sidebar.classList.add('sidebar-expanded');
                mainContent.classList.add('main-expanded');
            }
            
            // Handle window resize
            window.addEventListener('resize', function() {
                // On small screens, always collapse sidebar
                if (window.innerWidth < 768 && sidebar.classList.contains('sidebar-expanded')) {
                    // Trigger click on the toggle button
                    toggleSidebarBtn.click();
                }
            });
        });
    </script>

@livewireScripts

</body>
</html>