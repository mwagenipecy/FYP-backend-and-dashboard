<div>

<x-breadcrumb :items="[
    ['label' => 'Idea Listing', 'url' => route('idea.list')],
   
]" />


    <div class="max-w-7xl mx-auto">


 
     <!-- Project idea metrix  -->


     <livewire:project-idea.idea-metrix />






      <!-- Line Chart Section -->
    <div class="grid grid-cols-12 gap-4">
        <!-- Card section spanning 8/12 columns -->
        <div class="col-span-12 md:col-span-12">
            <div class="max-w-full w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
                <div class="flex justify-between mb-5">
                    <div class="flex justify-between mb-3">
                        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1">Ideas Trend</h5>
                    </div>
                    <div>
                        <button id="dropdownDefaultButton" data-dropdown-toggle="lastDaysdropdown"
                            data-dropdown-placement="bottom" type="button"
                            class="px-3 py-2 inline-flex items-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            Filter
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="lastDaysdropdown"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownDefaultButton">
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Monthly</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Daily</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="line-chart"></div>
            </div>
            {{-- @livewire('line-chart', [
                'chartId' => 'expenses-trend',
                'chartTitle' => 'Expenses Trend',
                'data' => $lineChartData,
                'labels' => $lineChartLabels
            ]) --}}
        </div>
        
        
    </div>


    
    <div class="  mt-8">
    <div class="bg-white shadow-md rounded-lg p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between space-y-4 sm:space-y-0 sm:space-x-6">
        
        <!-- Description -->
        <div class="text-gray-700 max-w-xl">
            <h2 class="text-lg font-semibold mb-1">Submit a New Project Idea</h2>
            <p class="text-sm text-gray-500">Share your innovative ideas for upcoming projects. Your idea could be the next big thing!</p>
        </div>

        <!-- Add Project Button -->
        <button  data-modal-target="createIdeaModal" data-modal-toggle="createIdeaModal"
           class="inline-flex items-center px-5 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Add Project Idea
            </button>

    </div>
</div>


        
 <!-- Search, Filters and Actions Bar -->
<div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6 mt-5">
    <div class="flex flex-col sm:flex-row justify-between mb-4">
        <h2 class="text-lg font-medium text-gray-900 mb-4 sm:mb-0">Project Ideas</h2>
        
        <!-- Download Button -->
        <div class="flex space-x-2">
            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Download CSV
            </button>
            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Export Excel
            </button>
        </div>
    </div>
    
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" wire:model.debounce.300ms="search" id="search" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Search by title or description">
            </div>
        </div>
        
        <div>
            <label for="statusFilter" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="statusFilter" wire:model="statusFilter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">All Statuses</option>
                <option value="submitted">Submitted</option>
                <option value="under_review">Under Review</option>
                <option value="needs_qualification">Needs Qualification</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        
        <div>
            <label for="sortBy" class="block text-sm font-medium text-gray-700">Sort By</label>
            <select id="sortBy" wire:model="sortBy" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="created_at">Date Submitted</option>
                <option value="title">Title</option>
                <option value="status">Status</option>
            </select>
        </div>
    </div>
</div>

<!-- Project Ideas Table -->
<div class="mt-5 bg-white shadow overflow-hidden sm:rounded-md">
    @if ($projectIdeas->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Category
                        </th>

                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Submitted By
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date Submitted
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">View</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($projectIdeas as $idea)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-indigo-600">{{ $idea->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-indigo-600">{{ $idea->idea_type }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-200">
                                            <span class="text-sm font-medium leading-none text-gray-700">{{ substr($idea->user->name, 0, 1) }}</span>
                                        </span>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $idea->user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($idea->status == 'submitted') bg-blue-100 text-blue-800 
                                    @elseif($idea->status == 'under_review') bg-yellow-100 text-yellow-800 
                                    @elseif($idea->status == 'needs_qualification') bg-purple-100 text-purple-800 
                                    @elseif($idea->status == 'approved') bg-green-100 text-green-800 
                                    @elseif($idea->status == 'rejected') bg-red-100 text-red-800 
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $idea->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $idea->created_at->format('M d, Y') }}
                                <span class="text-xs text-gray-400">{{ $idea->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('project-ideas.show', $idea->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
            {{ $projectIdeas->links() }}
        </div>
    @else
        <div class="px-4 py-8 sm:p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">No project ideas found</h3>
            <p class="mt-1 text-sm text-gray-500">Try changing your search filters or add a new project idea.</p>
            <div class="mt-6">
                <a href="{{ route('project-ideas.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Project Idea
                </a>
            </div>
        </div>
    @endif
</div>




    </div>





 <!-- script section  -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure ApexCharts is loaded
            if (typeof ApexCharts !== 'undefined') {
                const metrics = @json($metrics ?? []);
                const ideaMonthlyTrend = metrics.ideaMonthlyTrend || [10, 41, 35, 51, 49, 62, 69, 91, 148, 100,
                    120, 150
                ];

                // Prepare data for donut chart
                const incomeByChannel = metrics.incomeByChannel || [];

                // Extract series and labels from incomeByChannel
                const series = incomeByChannel.map(channel => channel.amount);
                const labels = incomeByChannel.map(channel => channel.channel);

                // LineChartOptions
                const lineChartOptions = {
                    chart: {
                        height: "100%",
                        maxWidth: "100%",
                        type: "area",
                        fontFamily: "Inter, sans-serif",
                        dropShadow: {
                            enabled: false,
                        },
                        toolbar: {
                            show: false,
                        },
                    },
                    tooltip: {
                        enabled: true,
                        x: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    stroke: {
                        width: 6,
                        curve: 'smooth'
                    },
                    grid: {
                        show: true,
                        strokeDashArray: 4,
                        padding: {
                            left: 2,
                            right: 2,
                            top: -26
                        },
                    },
                    series: [{
                        name: "Ideas",
                        data: ideaMonthlyTrend,
                        color: "#1A56DB",
                    }],
                    legend: {
                        show: false
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                            'Nov', 'Dec'
                        ],
                        labels: {
                            show: true,
                            style: {
                                fontFamily: "Inter, sans-serif",
                                cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                            }
                        },
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false,
                        },
                    },
                    yaxis: {
                        show: true,
                    },
                };

                // Define color palette
                const colors = [
                    "#1C64F2", // Blue
                    "#16BDCA", // Teal
                    "#FDBA8C", // Orange
                    "#E74694", // Pink
                    "#7E3AF2", // Purple
                    // Add more colors if needed
                ];

                // Donut Chart Options
                const donutChartOptions = {
                    series: series,
                    colors: colors.slice(0, series.length), // Use as many colors as series
                    chart: {
                        height: 320,
                        width: "100%",
                        type: "donut",
                    },
                    stroke: {
                        colors: ["transparent"],
                        lineCap: "",
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontFamily: "Inter, sans-serif",
                                        offsetY: 20,
                                    },
                                    total: {
                                        showAlways: false,
                                        show: false,
                                        label: "Total Income",
                                        fontFamily: "Inter, sans-serif",
                                        fontSize: "9px",
                                        formatter: function(w) {
                                            const sum = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                            return '$' + sum.toLocaleString('en-US', {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            });
                                        },
                                    },
                                    value: {
                                        show: true,
                                        fontFamily: "Inter, sans-serif",
                                        offsetY: -20,
                                        formatter: function(value) {
                                            return '$' + value.toLocaleString('en-US', {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            });
                                        },
                                    },
                                },
                                size: "80%",
                            },
                        },
                    },
                    grid: {
                        padding: {
                            top: -2,
                        },
                    },
                    labels: labels,
                    dataLabels: {
                        enabled: false,
                        formatter: function(val, opts) {
                            return opts.w.config.series[opts.seriesIndex].toLocaleString('en-US', {
                                style: 'percent',
                                minimumFractionDigits: 1,
                                maximumFractionDigits: 1
                            });
                        },
                    },
                    legend: {
                        position: "right",
                        fontFamily: "Inter, sans-serif",
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                // Render Line Chart
                if (document.getElementById("line-chart")) {
                    const lineChart = new ApexCharts(document.getElementById("line-chart"), lineChartOptions);
                    lineChart.render();
                }

                // Render Donut Chart
                if (document.getElementById("donut-chart")) {
                    const donutChart = new ApexCharts(
                        document.getElementById("donut-chart"),
                        donutChartOptions
                    );
                    donutChart.render();

                    // Optional: Add interactivity
                    const checkboxes = document.querySelectorAll('#income-channels input[type="checkbox"]');

                    function handleCheckboxChange(event, chart) {
                        const checkbox = event.target;
                        const channelName = checkbox.value;

                        // Find the index of the channel
                        const channelIndex = labels.indexOf(channelName);

                        if (channelIndex !== -1) {
                            // Create a copy of the current series
                            const currentSeries = [...chart.w.globals.series];

                            if (checkbox.checked) {
                                // Modify the series (e.g., highlight specific channel)
                                currentSeries[channelIndex] *= 1.5; // Increase by 50%
                            } else {
                                // Restore original value
                                currentSeries[channelIndex] /= 1.5;
                            }

                            chart.updateSeries(currentSeries);
                        }
                    }

                    // Attach the event listener to each checkbox
                    checkboxes.forEach((checkbox) => {
                        checkbox.addEventListener('change', (event) => handleCheckboxChange(event,
                            donutChart));
                    });
                }
            } else {
                console.error('ApexCharts is not loaded.');
            }
        });
    </script>





<!-- modal section  -->

<div id="createIdeaModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full flex items-center justify-center">

    <!-- Overlay / Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>

    <!-- Modal content -->
    <div class="relative w-full max-w-2xl max-h-full z-50">
        <div class="bg-white rounded-lg shadow dark:bg-gray-700">
            
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    New Project Idea
                </h3>
                <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="createIdeaModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <livewire:project-idea.create />
            </div>
        </div>
    </div>
</div>


</div>