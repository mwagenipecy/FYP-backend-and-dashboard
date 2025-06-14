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
    
    .sidebar-bg {
        background: linear-gradient(135deg, #0a1629 0%, #0f2742 25%, #1e3a5f 50%, #2d4f7a 75%, #0763AF 100%);
    }
    
    .nav-item-active {
        background: linear-gradient(135deg, rgba(7, 99, 175, 0.25) 0%, rgba(255, 255, 255, 0.1) 50%, rgba(7, 99, 175, 0.15) 100%);
    }
    
    .nav-item-hover {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(7, 99, 175, 0.05) 100%);
    }
    
    .dropdown-item-hover {
        background: linear-gradient(135deg, rgba(7, 99, 175, 0.2) 0%, rgba(255, 255, 255, 0.05) 100%);
    }
    
    .dropdown-active {
        background: linear-gradient(135deg, rgba(7, 99, 175, 0.3) 0%, rgba(255, 255, 255, 0.1) 100%);
    }
    
    .section-divider {
        background: linear-gradient(90deg, transparent 0%, rgba(7, 99, 175, 0.4) 20%, rgba(255, 255, 255, 0.3) 50%, rgba(7, 99, 175, 0.4) 80%, transparent 100%);
    }
    
    .logout-gradient {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(185, 28, 28, 0.1) 100%);
    }
    
    .logout-hover:hover {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.25) 0%, rgba(185, 28, 28, 0.15) 100%);
    }
    
    .active-indicator {
        background: linear-gradient(to bottom, #0763AF, #ffffff);
    }
</style>

<!-- Sidebar Component -->
<aside class="fixed top-0 left-0 z-40 w-72 h-screen transition-transform duration-300 ease-in-out -translate-x-full sm:translate-x-0 sidebar-bg shadow-2xl border-r border-white/10 font-inter">
    
    <!-- Logo/Brand Area -->
    <div class="px-6 py-6 mb-6 border-b border-primary/20 backdrop-blur-sm bg-gradient-to-r from-primary/10 to-white/5">
        <div class="flex items-center space-x-3">
            <div class="relative">
                <div class="w-12 h-12 bg-gradient-to-br from-primary to-primary-light rounded-2xl flex items-center justify-center shadow-lg shadow-primary/30 transform hover:scale-105 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white drop-shadow-lg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                </div>
                <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full animate-pulse shadow-lg"></div>
            </div>
            <div>
                <h2 class="text-xl font-bold text-white tracking-tight">Admin Hub</h2>
                <p class="text-sm text-slate-300 font-medium">Management Portal</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="h-full px-4 pb-4 overflow-y-auto scrollbar-thin scrollbar-track-transparent scrollbar-thumb-white/20">
        <nav class="space-y-3">
            
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="nav-item group flex items-center p-4 text-slate-300 rounded-2xl transition-all duration-300 ease-out hover:transform hover:translate-x-2 hover:scale-[1.02] hover:shadow-xl hover:shadow-primary/20 nav-item-hover border border-transparent hover:border-white/10 backdrop-blur-sm relative overflow-hidden {{ request()->is('dashboard*') ? 'nav-item-active translate-x-2 scale-[1.02] shadow-lg shadow-primary/30 border-primary/30 text-white' : '' }}">
                <div class="absolute left-0 top-0 bottom-0 w-1 active-indicator transform {{ request()->is('dashboard*') ? 'scale-y-100' : 'scale-y-0' }} group-hover:scale-y-100 transition-transform duration-300 rounded-r-full"></div>
                <div class="relative">
                    <svg class="flex-shrink-0 w-6 h-6 {{ request()->is('dashboard*') ? 'text-primary scale-110 drop-shadow-lg' : 'text-slate-400' }} transition-all duration-300 group-hover:text-primary group-hover:scale-110 group-hover:drop-shadow-lg" fill="currentColor" viewBox="0 0 18 18">
                        <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                    </svg>
                </div>
                <span class="ml-4 font-semibold text-sm tracking-wide transition-all duration-300 {{ request()->is('dashboard*') ? 'text-white translate-x-1' : '' }} group-hover:text-white group-hover:translate-x-1">Dashboard</span>
                <div class="ml-auto {{ request()->is('dashboard*') ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-opacity duration-300">
                    <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
                </div>
            </a>

            <!-- Idea Management -->
            <a href="{{ route('idea.list') }}" class="nav-item group flex items-center p-4 text-slate-300 rounded-2xl transition-all duration-300 ease-out hover:transform hover:translate-x-2 hover:scale-[1.02] hover:shadow-xl hover:shadow-primary/20 nav-item-hover border border-transparent hover:border-white/10 backdrop-blur-sm relative overflow-hidden {{ request()->is('idea*') ? 'nav-item-active translate-x-2 scale-[1.02] shadow-lg shadow-primary/30 border-primary/30 text-white' : '' }}">
                <div class="absolute left-0 top-0 bottom-0 w-1 active-indicator transform {{ request()->is('idea*') ? 'scale-y-100' : 'scale-y-0' }} group-hover:scale-y-100 transition-transform duration-300 rounded-r-full shadow-lg shadow-primary/50"></div>
                <div class="relative">
                    <svg class="flex-shrink-0 w-6 h-6 {{ request()->is('idea*') ? 'text-primary scale-110 drop-shadow-lg' : 'text-slate-400' }} transition-all duration-300 group-hover:text-primary group-hover:scale-110 group-hover:drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13.5 2c-.178 0-.356.013-.492.022l-.074.005a1 1 0 0 0-.934.998V11a1 1 0 0 0 1 1h7.975a1 1 0 0 0 .998-.934l.005-.074A7.04 7.04 0 0 0 22 10.5 8.5 8.5 0 0 0 13.5 2Z"/>
                        <path d="M11 6.025a1 1 0 0 0-1.065-.998 8.5 8.5 0 1 0 9.038 9.039A1 1 0 0 0 17.975 13H11V6.025Z"/>
                    </svg>
                </div>
                <span class="ml-4 font-semibold text-sm tracking-wide transition-all duration-300 {{ request()->is('idea*') ? 'text-white font-bold drop-shadow-sm translate-x-1' : '' }} group-hover:text-white group-hover:translate-x-1">Idea Management</span>
                <div class="ml-auto {{ request()->is('idea*') ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-opacity duration-300">
                    <div class="w-2 h-2 {{ request()->is('idea*') ? 'bg-white' : 'bg-primary' }} rounded-full animate-pulse {{ request()->is('idea*') ? 'shadow-lg' : '' }}"></div>
                </div>
            </a>

            <!-- Project Management -->
            <a href="{{ route('project.list') }}" class="nav-item group flex items-center p-4 text-slate-300 rounded-2xl transition-all duration-300 ease-out hover:transform hover:translate-x-2 hover:scale-[1.02] hover:shadow-xl hover:shadow-primary/20 nav-item-hover border border-transparent hover:border-white/10 backdrop-blur-sm relative overflow-hidden {{ request()->is('project*') ? 'nav-item-active translate-x-2 scale-[1.02] shadow-lg shadow-primary/30 border-primary/30 text-white' : '' }}">
                <div class="absolute left-0 top-0 bottom-0 w-1 active-indicator transform {{ request()->is('project*') ? 'scale-y-100' : 'scale-y-0' }} group-hover:scale-y-100 transition-transform duration-300 rounded-r-full"></div>
                <div class="relative">
                    <svg class="flex-shrink-0 w-6 h-6 {{ request()->is('project*') ? 'text-primary scale-110 drop-shadow-lg' : 'text-slate-400' }} transition-all duration-300 group-hover:text-primary group-hover:scale-110 group-hover:drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m8-2h3m-3 3h3m-4 3v6m4-3H8M19 4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 12v6h8v-6H8Z"/>
                    </svg>
                </div>
                <span class="ml-4 font-semibold text-sm tracking-wide transition-all duration-300 {{ request()->is('project*') ? 'text-white translate-x-1' : '' }} group-hover:text-white group-hover:translate-x-1">Project Management</span>
                <div class="ml-auto {{ request()->is('project*') ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-opacity duration-300">
                    <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
                </div>
            </a>

            <!-- Post Manager -->
            <a href="{{ route('blog.list') }}" class="nav-item group flex items-center p-4 text-slate-300 rounded-2xl transition-all duration-300 ease-out hover:transform hover:translate-x-2 hover:scale-[1.02] hover:shadow-xl hover:shadow-primary/20 nav-item-hover border border-transparent hover:border-white/10 backdrop-blur-sm relative overflow-hidden {{ request()->is('blog*') ? 'nav-item-active translate-x-2 scale-[1.02] shadow-lg shadow-primary/30 border-primary/30 text-white' : '' }}">
                <div class="absolute left-0 top-0 bottom-0 w-1 active-indicator transform {{ request()->is('blog*') ? 'scale-y-100' : 'scale-y-0' }} group-hover:scale-y-100 transition-transform duration-300 rounded-r-full"></div>
                <div class="relative">
                    <svg class="flex-shrink-0 w-6 h-6 {{ request()->is('blog*') ? 'text-primary scale-110 drop-shadow-lg' : 'text-slate-400' }} transition-all duration-300 group-hover:text-primary group-hover:scale-110 group-hover:drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="ml-4 font-semibold text-sm tracking-wide transition-all duration-300 {{ request()->is('blog*') ? 'text-white translate-x-1' : '' }} group-hover:text-white group-hover:translate-x-1">Post Manager</span>
                <div class="ml-auto {{ request()->is('blog*') ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-opacity duration-300">
                    <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
                </div>
            </a>

            <!-- Student Profile -->
            <a href="{{ route('student.profile.list') }}" class="nav-item group flex items-center p-4 text-slate-300 rounded-2xl transition-all duration-300 ease-out hover:transform hover:translate-x-2 hover:scale-[1.02] hover:shadow-xl hover:shadow-primary/20 nav-item-hover border border-transparent hover:border-white/10 backdrop-blur-sm relative overflow-hidden {{ request()->is('student*') ? 'nav-item-active translate-x-2 scale-[1.02] shadow-lg shadow-primary/30 border-primary/30 text-white' : '' }}">
                <div class="absolute left-0 top-0 bottom-0 w-1 active-indicator transform {{ request()->is('student*') ? 'scale-y-100' : 'scale-y-0' }} group-hover:scale-y-100 transition-transform duration-300 rounded-r-full"></div>
                <div class="relative">
                    <svg class="flex-shrink-0 w-6 h-6 {{ request()->is('student*') ? 'text-primary scale-110 drop-shadow-lg' : 'text-slate-400' }} transition-all duration-300 group-hover:text-primary group-hover:scale-110 group-hover:drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M9 8h10M9 12h10M9 16h10M4.99 8H5m-.02 4h.01m0 4H5"/>
                    </svg>
                </div>
                <span class="ml-4 font-semibold text-sm tracking-wide transition-all duration-300 {{ request()->is('student*') ? 'text-white translate-x-1' : '' }} group-hover:text-white group-hover:translate-x-1">Student Profile</span>
                <div class="ml-auto {{ request()->is('student*') ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-opacity duration-300">
                    <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
                </div>
            </a>

            <!-- Section Divider -->
            <div class="section-divider h-0.5 mx-4 my-6 rounded-full relative">
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-3 h-3 bg-gradient-to-r from-primary to-white rounded-full shadow-lg shadow-primary/50 animate-pulse"></div>
            </div>

            <!-- Hub Management Dropdown -->
            <div class="dropdown-section">
                <button type="button" onclick="toggleDropdown('hubDropdown')" class="dropdown-toggle w-full group flex items-center p-4 text-slate-300 rounded-2xl transition-all duration-300 ease-out hover:transform hover:translate-x-1 hover:scale-[1.01] nav-item-hover border border-transparent hover:border-white/10 backdrop-blur-sm">
                    <div class="relative">
                        <svg class="flex-shrink-0 w-6 h-6 text-slate-400 transition-all duration-300 group-hover:text-primary group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-width="2" d="M6 4v10m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v2m6-16v2m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v10m6-16v10m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v2"/>
                        </svg>
                    </div>
                    <span class="flex-1 ml-4 text-left font-semibold text-sm tracking-wide transition-all duration-300 group-hover:text-white">Hub Management</span>
                    <svg class="w-5 h-5 transition-transform duration-300 text-slate-400 group-hover:text-primary" id="hubDropdownIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <ul id="hubDropdown" class="hidden py-2 space-y-2 ml-6 border-l-2 border-primary/20">
                    <li>
                        <a href="{{ route('hub_list') }}" class="dropdown-item flex items-center w-full p-3 text-slate-400 rounded-xl transition-all duration-300 hover:text-white hover:transform hover:translate-x-3 hover:scale-[1.01] dropdown-item-hover border border-transparent hover:border-white/10 backdrop-blur-sm {{ request()->is('hub_list*') ? 'dropdown-active text-white shadow-md shadow-primary/20 border-primary/30' : '' }}">
                            <div class="w-2 h-2 {{ request()->is('hub_list*') ? 'bg-primary animate-pulse' : 'bg-slate-500' }} rounded-full mr-3 group-hover:bg-primary transition-colors duration-300"></div>
                            <span class="font-medium text-sm">Hub List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('hub.settings') }}" class="dropdown-item flex items-center w-full p-3 text-slate-400 rounded-xl transition-all duration-300 hover:text-white hover:transform hover:translate-x-3 hover:scale-[1.01] dropdown-item-hover border border-transparent hover:border-white/10 backdrop-blur-sm {{ request()->is('manage/income*') ? 'dropdown-active text-white shadow-md shadow-primary/20 border-primary/30' : '' }}">
                            <div class="w-2 h-2 {{ request()->is('manage/income*') ? 'bg-primary animate-pulse' : 'bg-slate-500' }} rounded-full mr-3 group-hover:bg-primary transition-colors duration-300"></div>
                            <span class="font-medium text-sm">Hub Settings</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- User Management Dropdown -->
            <div class="dropdown-section">
                <button type="button" onclick="toggleDropdown('userDropdown')" class="dropdown-toggle w-full group flex items-center p-4 text-slate-300 rounded-2xl transition-all duration-300 ease-out hover:transform hover:translate-x-1 hover:scale-[1.01] nav-item-hover border border-transparent hover:border-white/10 backdrop-blur-sm">
                    <div class="relative">
                        <svg class="flex-shrink-0 w-6 h-6 text-slate-400 transition-all duration-300 group-hover:text-primary group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                    <span class="flex-1 ml-4 text-left font-semibold text-sm tracking-wide transition-all duration-300 group-hover:text-white">User Management</span>
                    <svg class="w-5 h-5 transition-transform duration-300 text-slate-400 group-hover:text-primary" id="userDropdownIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <ul id="userDropdown" class="hidden py-2 space-y-2 ml-6 border-l-2 border-primary/20">
                    <li>
                        <a href="{{ route('staff.list') }}" class="dropdown-item flex items-center w-full p-3 text-slate-400 rounded-xl transition-all duration-300 hover:text-white hover:transform hover:translate-x-3 hover:scale-[1.01] dropdown-item-hover border border-transparent hover:border-white/10 backdrop-blur-sm {{ request()->is('staff*') ? 'dropdown-active text-white shadow-md shadow-primary/20 border-primary/30' : '' }}">
                            <div class="w-2 h-2 {{ request()->is('staff*') ? 'bg-primary animate-pulse' : 'bg-slate-500' }} rounded-full mr-3 group-hover:bg-primary transition-colors duration-300"></div>
                            <span class="font-medium text-sm">Staffs</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('onboarding.member') }}" class="dropdown-item flex items-center w-full p-3 text-slate-400 rounded-xl transition-all duration-300 hover:text-white hover:transform hover:translate-x-3 hover:scale-[1.01] dropdown-item-hover border border-transparent hover:border-white/10 backdrop-blur-sm {{ request()->is('onboarding*') ? 'dropdown-active text-white shadow-md shadow-primary/20 border-primary/30' : '' }}">
                            <div class="w-2 h-2 {{ request()->is('onboarding*') ? 'bg-primary animate-pulse' : 'bg-slate-500' }} rounded-full mr-3 group-hover:bg-primary transition-colors duration-300"></div>
                            <span class="font-medium text-sm">Member Onboarding</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Section Divider -->
            <div class="section-divider h-0.5 mx-4 my-6 rounded-full relative">
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-3 h-3 bg-gradient-to-r from-primary to-white rounded-full shadow-lg shadow-primary/50 animate-pulse"></div>
            </div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="logout-gradient logout-hover nav-item group flex items-center p-4 text-slate-300 rounded-2xl transition-all duration-300 ease-out hover:transform hover:translate-x-1 hover:-translate-y-1 hover:scale-[1.02] hover:shadow-xl hover:shadow-red-500/20 border border-red-400/20 hover:border-red-400/40 backdrop-blur-sm relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    <div class="relative">
                        <svg class="flex-shrink-0 w-6 h-6 text-red-400 transition-all duration-300 group-hover:text-red-300 group-hover:scale-110 group-hover:drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2"/>
                        </svg>
                    </div>
                    <span class="ml-4 font-semibold text-sm tracking-wide text-red-300 transition-all duration-300 group-hover:text-white relative z-10">Log Out</span>
                    <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="w-2 h-2 bg-red-400 rounded-full animate-pulse"></div>
                    </div>
                </a>
            </form>

        
            </a>
        </nav>
    </div>
</aside>

<script>
    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        const icon = document.getElementById(dropdownId + 'Icon');
        
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            icon.style.transform = 'rotate(180deg)';
            dropdown.style.maxHeight = dropdown.scrollHeight + 'px';
        } else {
            dropdown.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
            dropdown.style.maxHeight = '0';
        }
    }

    function handleLogout() {
        // Laravel form submission will be handled by the onclick event
        return false;
    }

    // Add active state management
    document.addEventListener('DOMContentLoaded', function() {
        const navItems = document.querySelectorAll('.nav-item:not(.dropdown-toggle)');
        
        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                // Remove active classes from all nav items
                navItems.forEach(nav => {
                    nav.classList.remove('nav-item-active', 'translate-x-2', 'scale-[1.02]', 'shadow-lg', 'shadow-primary/30', 'border-primary/30');
                    nav.classList.add('border-transparent');
                });
                
                // Add active class to clicked item
                if (!this.href.includes('#')) {
                    this.classList.add('nav-item-active', 'translate-x-2', 'scale-[1.02]', 'shadow-lg', 'shadow-primary/30', 'border-primary/30');
                    this.classList.remove('border-transparent');
                }
            });
        });
    });
</script>