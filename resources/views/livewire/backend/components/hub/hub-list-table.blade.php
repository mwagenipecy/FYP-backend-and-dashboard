<div>
 <!-- Filters -->
 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-6">
                <div class="col-span-1 lg:col-span-1">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" placeholder="Search for users" class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="col-span-1 lg:col-span-1">
                    <div class="relative">
                        <select class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Role</option>
                            <option value="admin">Administrator</option>
                            <option value="moderator">Moderator</option>
                            <option value="viewer">Viewer</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div class="col-span-1 lg:col-span-1">
                    <div class="relative">
                        <select class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div class="col-span-1 lg:col-span-1">
                    <div class="relative">
                        <select class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Type</option>
                            <option value="pro">PRO</option>
                            <option value="basic">Basic</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div class="col-span-1 lg:col-span-1">
                    <div class="relative">
                        <select class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Rating</option>
                            <option value="high">High (4.5+)</option>
                            <option value="medium">Medium (3.5-4.4)</option>
                            <option value="low">Low (Below 3.5)</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div class="col-span-1 lg:col-span-1">
                    <div class="relative">
                        <select class="w-full px-4 py-2 border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Country</option>
                            <option value="us">United States</option>
                            <option value="ca">Canada</option>
                            <option value="fr">France</option>
                            <option value="uk">England</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- View options -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-6">
                    <span class="text-gray-600">Show:</span>
                    <div class="flex items-center space-x-6">
                        <label class="inline-flex items-center">
                            <input type="radio" name="view" checked class="form-radio text-blue-600 h-4 w-4">
                            <span class="ml-2">All</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="view" class="form-radio text-blue-600 h-4 w-4">
                            <span class="ml-2">User Role</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="view" class="form-radio text-blue-600 h-4 w-4">
                            <span class="ml-2">Account Type</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="view" class="form-radio text-blue-600 h-4 w-4">
                            <span class="ml-2">Status</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="view" class="form-radio text-blue-600 h-4 w-4">
                            <span class="ml-2">Rating</span>
                        </label>
                    </div>
                </div>
                <div class="relative">
                    <button class="flex items-center space-x-1 text-gray-600 border border-gray-200 rounded-lg px-4 py-2 focus:outline-none hover:bg-gray-50">
                        <span>Actions</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                </div>
            </div>



            <!-- User table -->
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="w-12 px-6 py-4">
                                <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">  Name</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supervisor </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> No of Projects </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">address</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- User 1 -->

                        @foreach ($hubs as $hub)


                       
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="{{ asset($hub->image) }}" alt="User">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $hub->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <i class="fas fa-lock mr-1"></i> Administrator
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $hub->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $hub->phone_number }}</div>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                                    <span class="text-sm text-gray-900"> 12 </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $hub->address }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">

                               @if($hub->status == 'active')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-circle text-xs mr-1"></i> Active
                                </span>
                                @elseif($hub->status == 'inactive')

                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-circle text-xs mr-1"></i> Inactive
                                </span>

                                @endif 

      


                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button  class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        
        </div>
