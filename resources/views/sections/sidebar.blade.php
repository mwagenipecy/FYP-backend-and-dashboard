<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 xy:bg-gray-800 xy:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white xy:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex  {{ request()->is('dashboard*') ? 'rounded-md bg-blue-500 text-white' : '' }}  items-center p-2 text-gray-900 rounded-lg xy:text-white hover:bg-gray-100 xy:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 xy:text-gray-400 group-hover:text-gray-900 xy:group-hover:text-white  {{ request()->is('dashboard*') ? 'rounded-md bg-blue-500 text-white' : '' }}  "
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                        <path
                            d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                    </svg>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href=" "
                    class="flex items-center p-2  {{ request()->is('file-management*') ? 'rounded-md bg-blue-500 text-white' : '' }}   text-gray-900 rounded-lg xy:text-white hover:bg-gray-100 xy:hover:bg-gray-700 group">
                    {{-- <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 xy:text-gray-400 group-hover:text-gray-900 xy:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                        <path
                            d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                    </svg> --}}
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 xy:text-gray-400 group-hover:text-gray-900 xy:group-hover:text-white  {{ request()->is('dashboard*') ? 'rounded-md bg-blue-500 text-white' : '' }} "
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.5 8H4m0-2v13a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1h-5.032a1 1 0 0 1-.768-.36l-1.9-2.28a1 1 0 0 0-.768-.36H5a1 1 0 0 0-1 1Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Documents</span>
                </a>
            </li>

            <li>
                <a href="{{ route('idea.list') }}"  
                    class="flex items-center p-2   {{ request()->is('idea*') ? 'rounded-md bg-blue-500 text-white' : '' }}
                     text-gray-900 rounded-lg xy:text-white hover:bg-gray-100 xy:hover:bg-gray-700 group">
                    <svg class="  {{ request()->is('project-idea*') ? 'rounded-md bg-blue-500 text-white' : '' }} flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 xy:text-gray-400 group-hover:text-gray-900 xy:group-hover:text-white 
                     "
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M13.5 2c-.178 0-.356.013-.492.022l-.074.005a1 1 0 0 0-.934.998V11a1 1 0 0 0 1 1h7.975a1 1 0 0 0 .998-.934l.005-.074A7.04 7.04 0 0 0 22 10.5 8.5 8.5 0 0 0 13.5 2Z" />
                        <path
                            d="M11 6.025a1 1 0 0 0-1.065-.998 8.5 8.5 0 1 0 9.038 9.039A1 1 0 0 0 17.975 13H11V6.025Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap"> Idea Management</span>
                </a>
            </li>


            
            <li>
                <a href="{{ route('project.list') }}"
                    class="flex items-center   {{ request()->is('project*') ? 'rounded-md bg-blue-500 text-white' : '' }}  p-2 text-gray-900 rounded-lg xy:text-white hover:bg-gray-100 xy:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 {{ request()->is('project*') ? 'rounded-md bg-blue-500 text-white' : '' }}   transition duration-75 xy:text-gray-400 group-hover:text-gray-900 xy:group-hover:text-white 
                      "
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 3v4a1 1 0 0 1-1 1H5m8-2h3m-3 3h3m-4 3v6m4-3H8M19 4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 12v6h8v-6H8Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Project management </span>
                </a>
            </li>



            <li>
                <a href="
                "
                    class="flex items-center p-2             text-gray-900 rounded-lg xy:text-white hover:bg-gray-100 xy:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 xy:text-gray-400 group-hover:text-gray-900 xy:group-hover:text-white {{ request()->is('loans*') ? 'rounded-md bg-blue-500 text-white' : '' }}  "
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap"> Other Menu</span>
                </a>
            </li>
          
            <li>
                <a href="
                "
                    class="flex items-center
                      p-2 text-gray-900 rounded-lg xy:text-white hover:bg-gray-100 xy:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 xy:text-gray-400 group-hover:text-gray-900 xy:group-hover:text-white 
                    "
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="M9 8h10M9 12h10M9 16h10M4.99 8H5m-.02 4h.01m0 4H5" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap"> Other menus </span>
                </a>
            </li>
            <li>
                <a href=" "
                    class="flex items-center p-2 
                    text-gray-900 rounded-lg xy:text-white hover:bg-gray-100 xy:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 xy:text-gray-400 group-hover:text-gray-900 xy:group-hover:text-white 
                     "
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Profiles</span>
                </a>
            </li>
           
        </ul>

        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 xy:border-gray-700">
            <li>
                <button type="button"
                    class="flex items-center 
                      w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 xy:text-white xy:hover:bg-gray-700"
                    aria-controls="managementDropdown" data-collapse-toggle="managementDropdown">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 xy:text-gray-400 xy:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 21">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 4v10m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v2m6-16v2m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v10m6-16v10m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v2"/>
                    </svg>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Hub Management</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="managementDropdown" class="hidden py-2 space-y-2">
                    <li>
                        <a href="{{ route('hub_list') }} "
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 xy:text-white xy:hover:bg-gray-700 {{ request()->is('hub*') ? 'rounded-md bg-blue-500 text-white' : '' }}  "> Hub List </a>
                    </li>
                    <!-- <li>
                        <a href="#"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 xy:text-white xy:hover:bg-gray-700">Investment Accounts</a>
                    </li> -->
                    <li>
                        <a href="{{ route('hub.settings') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 xy:text-white xy:hover:bg-gray-700 {{ request()->is('manage/income*') ? 'rounded-md bg-blue-500 text-white' : '' }}  "> Hub Settings </a>
                    </li>

                    <!-- <li>
                        <a href=""
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 xy:text-white xy:hover:bg-gray-700 {{ request()->is('manage/penalties*') ? 'rounded-md bg-blue-500 text-white' : '' }}  ">Penalty Manager</a>
                    </li> -->

                </ul>
            </li>
        </ul>


        <!-- user management  -->
        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 xy:border-gray-700">
            <li>
                <button type="button"
                    class="flex items-center 
                      w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 xy:text-white xy:hover:bg-gray-700"
                    aria-controls="userDropdown" data-collapse-toggle="userDropdown">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 xy:text-gray-400 xy:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 21">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 4v10m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v2m6-16v2m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v10m6-16v10m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v2"/>
                    </svg>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap"> User Management</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="userDropdown" class="hidden py-2 space-y-2">
                    <li>
                        <a href="{{ route('staff.list') }} "
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 xy:text-white xy:hover:bg-gray-700 {{ request()->is('staff*') ? 'rounded-md bg-blue-500 text-white' : '' }}  "> Staffs </a>
                    </li>
                    <!-- <li>
                        <a href="#"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 xy:text-white xy:hover:bg-gray-700">Investment Accounts</a>
                    </li> -->
                    <li>
                        <a href="{{ route('onboarding.member') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 xy:text-white xy:hover:bg-gray-700 {{ request()->is('onboarding*') ? 'rounded-md bg-blue-500 text-white' : '' }}  ">Member Onboarding </a>
                    </li>

                    <!-- <li>
                        <a href=""
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 xy:text-white xy:hover:bg-gray-700 {{ request()->is('manage/penalties*') ? 'rounded-md bg-blue-500 text-white' : '' }}  ">Penalty Manager</a>
                    </li> -->

                </ul>
            </li>
        </ul>




        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 xy:border-gray-700">
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center p-2 text-gray-900 rounded-lg xy:text-white hover:bg-gray-100 xy:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 xy:text-gray-400 group-hover:text-gray-900 xy:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Log Out</span>
                    </a>
                </form>
            </li>
        </ul>
    </div>
</aside>
