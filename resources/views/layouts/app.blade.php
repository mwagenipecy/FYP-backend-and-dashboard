<!DOCTYPE html>
<html lang="en">
<head>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>uhub </title>
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <style>
        .sidebar-collapsed {
            width: 5rem;
        }
        .sidebar-expanded {
            width: 16rem;
        }
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .submenu.open {
            max-height: 500px;
            transition: max-height 0.5s ease-in;
        }
        .content-collapsed {
            margin-left: 5rem;
        }
        .content-expanded {
            margin-left: 16rem;
        }
        .nav-collapsed {
            left: 5rem;
        }
        .nav-expanded {
            left: 16rem;
        }
        .sidebar-text {
            transition: opacity 0.2s ease-in-out;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .content-expanded {
                margin-left: 0;
            }
            .content-collapsed {
                margin-left: 0;
            }
            .nav-expanded {
                left: 0;
                width: 100%;
            }
            .nav-collapsed {
                left: 0;
                width: 100%;
            }
            #sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            #sidebar.sidebar-mobile-open {
                transform: translateX(0);
            }
        }
        
        /* Dropdown styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 50;
            border-radius: 0.5rem;
        }
        .dropdown-content.show {
            display: block;
        }
        .dropdown-content a {
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            color: #333;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        
        /* Notification styles */
        .notification-item {
            border-bottom: 1px solid #eee;
        }
        .notification-item:last-child {
            border-bottom: none;
        }
        
        /* Main content container styles */
        .main-content-container {
            width: 100%;
            height: calc(100vh - 64px); /* Adjust based on your navbar height */
            overflow-y: auto;
            padding: 1.5rem;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <livewire:backend.sidebar />
      
        <!-- Content Area -->
        <div id="content" class="transition-all duration-300 content-expanded flex flex-col h-screen overflow-hidden">
            <!-- Top Navigation Bar -->
            <livewire:backend.navbar />

            <!-- Main Content -->
            <main class="bg-white flex-grow overflow-auto">
                <div class="main-content-container">
                    @yield('main-content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <script>
        // Toggle sidebar function
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const topNav = document.getElementById('topNav');
        const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');
        const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');

        sidebarToggleBtn.addEventListener('click', () => {
            // Toggle sidebar width
            if (sidebar.classList.contains('sidebar-expanded')) {
                sidebar.classList.remove('sidebar-expanded');
                sidebar.classList.add('sidebar-collapsed');
                content.classList.remove('content-expanded');
                content.classList.add('content-collapsed');
                topNav.classList.remove('nav-expanded');
                topNav.classList.add('nav-collapsed');
                
                // Hide text elements in sidebar
                sidebarTexts.forEach(text => {
                    text.style.opacity = '0';
                    text.style.display = 'none';
                });
            } else {
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.add('sidebar-expanded');
                content.classList.remove('content-collapsed');
                content.classList.add('content-expanded');
                topNav.classList.remove('nav-collapsed');
                topNav.classList.add('nav-expanded');
                
                // Show text elements in sidebar
                sidebarTexts.forEach(text => {
                    text.style.display = 'inline';
                    setTimeout(() => {
                        text.style.opacity = '1';
                    }, 100);
                });
            }
        });

        // Mobile sidebar toggle
        mobileSidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-mobile-open');
        });

        // Close sidebar on outside click for mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !mobileSidebarToggle.contains(e.target) && 
                sidebar.classList.contains('sidebar-mobile-open')) {
                sidebar.classList.remove('sidebar-mobile-open');
            }
        });

        // Collapsible submenu functionality
        const collapseButtons = document.querySelectorAll('.collapse-btn');
        
        collapseButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Find the submenu that's a sibling of this button
                const submenu = button.nextElementSibling;
                
                // Toggle the submenu
                if (submenu.classList.contains('open')) {
                    submenu.classList.remove('open');
                } else {
                    // Close all other submenus
                    document.querySelectorAll('.submenu.open').forEach(openSubmenu => {
                        if (openSubmenu !== submenu) {
                            openSubmenu.classList.remove('open');
                        }
                    });
                    
                    // Open this submenu
                    submenu.classList.add('open');
                }
            });
        });

        // Notification dropdown functionality
        const notificationDropdownButton = document.getElementById('notificationDropdownButton');
        const notificationDropdown = document.getElementById('notificationDropdown');

        if (notificationDropdownButton && notificationDropdown) {
            notificationDropdownButton.addEventListener('click', (e) => {
                e.stopPropagation();
                notificationDropdown.classList.toggle('show');
            });

            // Close notification dropdown on outside click
            document.addEventListener('click', (e) => {
                if (!notificationDropdown.contains(e.target) && !notificationDropdownButton.contains(e.target)) {
                    notificationDropdown.classList.remove('show');
                }
            });
        }

        // User profile dropdown functionality
        const userDropdownButton = document.getElementById('userDropdownButton');
        const userDropdown = document.getElementById('userDropdown');

        if (userDropdownButton && userDropdown) {
            userDropdown.classList.remove('show');
            userDropdownButton.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('show');
            });

            // Close user profile dropdown on outside click
            document.addEventListener('click', (e) => {
                if (!userDropdown.contains(e.target) && !userDropdownButton.contains(e.target)) {
                    userDropdown.classList.remove('show');
                }
            });
        }
    </script>
</body>
</html>