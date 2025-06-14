<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'primary': '#0763AF',
                    'primary-dark': '#054a87',
                    'primary-light': '#0876d4'
                }
            }
        }
    }
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    
    .navbar-gradient {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%);
        backdrop-filter: blur(20px);
    }
    
    .navbar-shadow {
        box-shadow: 0 4px 32px rgba(7, 99, 175, 0.08), 0 1px 0 rgba(7, 99, 175, 0.05);
    }
    
    .profile-gradient {
        background: linear-gradient(135deg, #0763AF 0%, #0876d4 100%);
    }
    
    .dropdown-gradient {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        backdrop-filter: blur(20px);
    }
</style>

<!-- Enhanced Admin Navbar -->
<nav class="fixed top-0 z-50 w-full navbar-gradient border-b border-primary/10 navbar-shadow font-inter">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <!-- Left Section -->
            <div class="flex items-center justify-start rtl:justify-end">
                <!-- Mobile Menu Button -->
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2.5 text-gray-500 rounded-xl sm:hidden hover:bg-primary/10 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all duration-300 hover:text-primary hover:scale-105 border border-transparent hover:border-primary/20">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6 transition-transform duration-300 hover:rotate-90" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                
                <!-- Logo -->
                <a href="{{ url('/') }}" class="hidden lg:flex items-center text-3xl font-bold text-gray-900 transition-all duration-300 hover:scale-105 group">
                    <div class="relative mr-3">
                        <img class="w-auto h-16 transition-all duration-300 group-hover:scale-110 drop-shadow-lg" 
                             src="{{ asset('/dashboard/mainLogo.png') }}" alt="logo">

                         </div>
                   
                </a>
            </div>
            
            <!-- Right Section -->
            <div class="flex items-center space-x-4">
                <!-- User Profile Dropdown -->
                <div class="flex items-center">
                    <div class="relative">
                        <button type="button"
                            class="flex items-center p-1 text-sm profile-gradient rounded-full focus:ring-4 focus:ring-primary/20 transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-primary/30 border-2 border-white"
                            aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-10 h-10 rounded-full border-2 border-white shadow-lg transition-all duration-300 hover:border-primary/20"
                                src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
                        </button>
                        
                        <!-- Online Status Indicator -->
                        <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-green-400 border-2 border-white rounded-full animate-pulse shadow-lg"></div>
                    </div>
                    
                    <!-- Dropdown Menu -->
                    <div class="z-50 hidden my-4 text-base list-none dropdown-gradient divide-y divide-gray-100 rounded-2xl shadow-2xl border border-primary/10"
                        id="dropdown-user">
                        <!-- User Info Header -->
                        <div class="px-6 py-4 bg-gradient-to-r from-primary/5 to-primary-light/5 rounded-t-2xl border-b border-primary/10" role="none">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 profile-gradient rounded-full flex items-center justify-center shadow-lg">
                                    <span class="text-white font-bold text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 tracking-wide" role="none">
                                        {{ Auth::user()->name }}
                                    </p>
                                    <p class="text-xs font-medium text-gray-600 truncate" role="none">
                                        {{ Auth::user()->email }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Menu Items -->
                        <ul class="py-2" role="none">
                            <li>
                                <a href="{{ route('dashboard') }}"
                                    class="group flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-primary/5 transition-all duration-300 hover:text-primary hover:translate-x-2 border-l-4 border-transparent hover:border-primary"
                                    role="menuitem">
                                    <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-primary transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="group flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-primary/5 transition-all duration-300 hover:text-primary hover:translate-x-2 border-l-4 border-transparent hover:border-primary"
                                    role="menuitem">
                                    <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-primary transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                    </svg>
                                    Settings
                                </a>
                            </li>
                            
                            <!-- Divider -->
                            <li class="my-2">
                                <div class="mx-4 border-t border-gray-200"></div>
                            </li>
                            
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="group flex items-center px-6 py-3 text-sm text-red-600 hover:bg-red-50 transition-all duration-300 hover:text-red-700 hover:translate-x-2 border-l-4 border-transparent hover:border-red-500 rounded-b-2xl"
                                        role="menuitem">
                                        <svg class="w-4 h-4 mr-3 text-red-400 group-hover:text-red-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Sign out
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    // Toggle dropdown functionality
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownButton = document.querySelector('[data-dropdown-toggle="dropdown-user"]');
        const dropdownMenu = document.getElementById('dropdown-user');
        
        if (dropdownButton && dropdownMenu) {
            dropdownButton.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        }
        
        // Mobile sidebar toggle (if you have the sidebar)
        const sidebarToggle = document.querySelector('[data-drawer-toggle="logo-sidebar"]');
        const sidebar = document.getElementById('logo-sidebar');
        
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
            });
        }
    });
</script>