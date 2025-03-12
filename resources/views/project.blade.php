
    <div class="container mx-auto px-4 py-6">
        <!-- Breadcrumb Navigation -->
        <div class="flex items-center text-sm mb-6">
            <a href="#" class="text-gray-600 hover:text-blue-600 flex items-center">
                <i class="fas fa-home mr-2"></i>
                <span>Home</span>
            </a>
            <i class="fas fa-chevron-right mx-3 text-gray-400 text-xs"></i>
            <a href="#" class="text-gray-600 hover:text-blue-600">Project management</a>
            <i class="fas fa-chevron-right mx-3 text-gray-400 text-xs"></i>
            <span class="text-gray-800 font-medium">All projects</span>
        </div>

        <!-- Header and Add Button -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">All projects</h1>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fas fa-plus mr-2"></i>
                <span>Add new project</span>
            </button>
        </div>

        <!-- Search and Filters -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" placeholder="Search for projects" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div class="relative">
                <select class="w-full px-4 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Status</option>
                    <option>Completed</option>
                    <option>In progress</option>
                    <option>In review</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
            
            <div class="relative">
                <select class="w-full px-4 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Number of users</option>
                    <option>1-2</option>
                    <option>3-5</option>
                    <option>5+</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
            
            <div class="relative">
                <select class="w-full px-4 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Just started</option>
                    <option>Last week</option>
                    <option>Last month</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
            
            <div class="relative">
                <select class="w-full px-4 py-2 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Due date</option>
                    <option>This week</option>
                    <option>This month</option>
                    <option>Next month</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Filter Options -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-6">
                <span class="text-gray-600 font-medium">Show:</span>
                <label class="inline-flex items-center">
                    <input type="radio" name="filter" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" checked>
                    <span class="ml-2 text-gray-700">All</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="filter" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                    <span class="ml-2 text-gray-700">Completed</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="filter" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                    <span class="ml-2 text-gray-700">In progress</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="filter" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                    <span class="ml-2 text-gray-700">In review</span>
                </label>
            </div>
            <div class="relative">
                <button class="px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-700 flex items-center focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span>Actions</span>
                    <i class="fas fa-chevron-down ml-2 text-gray-400"></i>
                </button>
            </div>
        </div>

        <!-- Projects Table -->
        <div class="overflow-x-auto border border-gray-200 rounded-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left">
                            <input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Users
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Progress
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Preview
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Time Tracking
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Due Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Project 1 -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Upload feed and Reels in Instagram</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                In progress
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex -space-x-2">
                                <img class="h-8 w-8 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/45.jpg" alt="">
                                <img class="h-8 w-8 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/men/44.jpg" alt="">
                                <img class="h-8 w-8 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/46.jpg" alt="">
                                <div class="flex items-center justify-center h-8 w-8 rounded-full border-2 border-white bg-gray-800 text-xs text-white">
                                    +5
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 75%"></div>
                            </div>
                            <div class="text-xs text-right mt-1 text-gray-500">75%</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="#" class="text-blue-600 hover:text-blue-900 flex items-center">
                                <i class="fas fa-link mr-2"></i>
                                <span>Website</span>
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i class="far fa-clock text-gray-400 mr-2"></i>
                                <span class="text-sm text-gray-500">6:47/8:00</span>
                                <span class="ml-2 inline-flex items-center justify-center h-6 w-6 rounded bg-orange-500 text-white">
                                    <i class="fas fa-pause text-xs"></i>
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            23 Nov 2025
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Project 2 -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Crossplatform analysis</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Completed
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex -space-x-2">
                                <img class="h-8 w-8 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/48.jpg" alt="">
                                <img class="h-8 w-8 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/men/47.jpg" alt="">
                                <img class="h-8 w-8 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/49.jpg" alt="">
                                <div class="flex items-center justify-center h-8 w-8 rounded-full border-2 border-white bg-gray-800 text-xs text-white">
                                    +2
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-500 h-2.5 rounded-full" style="width: 100%"></div>
                            </div>
                            <div class="text-xs text-right mt-1 text-gray-500">100%</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="#" class="text-blue-600 hover:text-blue-900 flex items-center">
                                <i class="fas fa-link mr-2"></i>
                                <span>Website</span>
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i class="far fa-clock text-gray-400 mr-2"></i>
                                <span class="text-sm text-gray-500">7:00</span>
                                <span class="ml-2 inline-flex items-center justify-center h-6 w-6 rounded bg-green-500 text-white">
                                    <i class="fas fa-check text-xs"></i>
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            03 Nov 2025
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Project 3 -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Product features analysis</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                In progress
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex -space-x-2">
                                <img class="h-8 w-8 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/52.jpg" alt="">
                                <img class="h-8 w-8 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/men/51.jpg" alt="">
                                <img class="h-8 w-8 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/men/50.jpg" alt="">
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 50%"></div>
                            </div>
                            <div class="text-xs text-right mt-1 text-gray-500">50%</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="#" class="text-blue-600 hover:text-blue-900 flex items-center">
                                <i class="fas fa-link mr-2"></i>
                                <span>Website</span>
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i class="far fa-clock text-gray-400 mr-2"></i>
                                <span class="text-sm text-gray-500">3:25/8:00</span>
                                <span class="ml-2 inline-flex items-center justify-center h-6 w-6 rounded bg-orange-500 text-white">
                                    <i class="fas fa-pause text-xs"></i>
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            Yesterday
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Additional projects would follow the same pattern -->
                </tbody>
            </table>
        </div>
    </div>
