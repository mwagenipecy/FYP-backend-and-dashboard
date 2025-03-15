<div>
<nav id="topNav" class="bg-white border-b border-gray-200 px-4 py-2.5 fixed right-0 top-0 z-30 transition-all duration-300 nav-expanded">
                <div class="flex flex-wrap justify-between items-center">
                    <!-- Left side - Menu Button + Search -->
                    <div class="flex items-center">
                        <button id="mobileSidebarToggle" data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button" class="p-2 mr-2 text-gray-600 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                          <!-- Toggle button before Flowbite logo -->
                    <button id="sidebarToggleBtn" class="p-2 sidebar rounded-lg text-gray-500 hover:bg-gray-100 focus:outline-none mr-2">
                        <svg id="toggleIcon" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                        
                        <!-- Search -->
                        <div class="relative ml-3 md:ml-0">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" id="search-navbar" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search">
                        </div>
                    </div>
                    
                    <!-- Right Icons -->
                    <div class="flex items-center">
                        <!-- Notification Dropdown -->
                        <div class="dropdown">
                            <button type="button" class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 mr-1" id="notificationDropdownButton">
                                <div class="relative">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                                    </svg>
                                    <!-- Notification Badge -->
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs">3</span>
                                </div>
                            </button>
                            <div id="notificationDropdown" class="dropdown-content mt-2 w-64 md:w-80">
                                <div class="p-3 bg-gray-100 border-b border-gray-200 rounded-t-lg">
                                    <h5 class="font-semibold text-gray-900">Notifications</h5>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <a href="#" class="notification-item flex p-3 hover:bg-gray-50">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">New user registered</p>
                                            <p class="text-xs text-gray-500">5 minutes ago</p>
                                        </div>
                                    </a>
                                    <a href="#" class="notification-item flex p-3 hover:bg-gray-50">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-500">
                                                <i class="fas fa-shopping-cart"></i>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">New order received</p>
                                            <p class="text-xs text-gray-500">2 hours ago</p>
                                        </div>
                                    </a>
                                    <a href="#" class="notification-item flex p-3 hover:bg-gray-50">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">System alert</p>
                                            <p class="text-xs text-gray-500">1 day ago</p>
                                        </div>
                                    </a>
                                </div>
                                <a href="#" class="block p-3 text-center text-sm font-medium text-blue-600 bg-gray-50 hover:bg-gray-100 rounded-b-lg">
                                    View all notifications
                                </a>
                            </div>
                        </div>
                        
                        <button type="button" class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 mr-1">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </button>
                        
                        <button type="button" class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 mr-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                        </button>
                        
                        <!-- User Profile Dropdown -->
                        <div class="dropdown">
                            <button type="button" class="flex text-sm rounded-full ml-2" id="userDropdownButton">
                                <img class="w-8 h-8 rounded-full" src="https://api.dicebear.com/7.x/adventurer/svg?seed=Felix&backgroundColor=b6e3f4" alt="user photo">
                            </button>
                            <div id="userDropdown" class="dropdown-content mt-2">
                                <div class="px-4 py-3 text-sm text-gray-900 border-b border-gray-200">
                                    <div class="font-medium">John Doe</div>
                                    <div class="truncate">john.doe@example.com</div>
                                </div>
                                <ul>
                                    <li>
                                        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">
                                            <i class="fas fa-user-circle mr-2 text-gray-500"></i>
                                            <span>Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">
                                            <i class="fas fa-cog mr-2 text-gray-500"></i>
                                            <span>Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">
                                            <i class="fas fa-list-alt mr-2 text-gray-500"></i>
                                            <span>Activity Log</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="border-t border-gray-200">
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>
                                        <span>Logout</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
