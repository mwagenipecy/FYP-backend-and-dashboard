{{-- resources/views/livewire/backend/staff/card.blade.php --}}
<div class="space-y-6">
    <!-- Summary Cards Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($totalUsers['total']) }}</p>
                    <div class="flex items-center mt-2">
                        <span class="text-sm {{ $growthPercentage >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <i class="fas fa-{{ $growthPercentage >= 0 ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                            {{ abs($growthPercentage) }}%
                        </span>
                        <span class="text-sm text-gray-500 ml-2">vs last month</span>
                    </div>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Students Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Students</p>
                    <p class="text-3xl font-bold text-purple-600">{{ number_format($totalUsers['students']) }}</p>
                    <p class="text-sm text-gray-500 mt-2">
                        {{ $totalUsers['total'] > 0 ? round(($totalUsers['students'] / $totalUsers['total']) * 100, 1) : 0 }}% of total
                    </p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Staff Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Staff</p>
                    <p class="text-3xl font-bold text-orange-600">{{ number_format($totalUsers['staff']) }}</p>
                    <p class="text-sm text-gray-500 mt-2">
                        {{ $totalUsers['total'] > 0 ? round(($totalUsers['staff'] / $totalUsers['total']) * 100, 1) : 0 }}% of total
                    </p>
                </div>
                <div class="p-3 bg-orange-100 rounded-full">
                    <i class="fas fa-user-tie text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Active Users Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Active Users</p>
                    <p class="text-3xl font-bold text-green-600">{{ number_format($totalUsers['active']) }}</p>
                    <p class="text-sm text-gray-500 mt-2">
                        {{ $totalUsers['total'] > 0 ? round(($totalUsers['active'] / $totalUsers['total']) * 100, 1) : 0 }}% active rate
                    </p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Registration Trends Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 sm:mb-0">User Registration Trends</h3>
                    <div class="flex flex-wrap gap-2">
                        <!-- Chart Type Selector -->
                        <div class="flex rounded-lg border border-gray-200 p-1">
                            
                            <button 
                                wire:click="updateChartType('bar')"
                                class="px-3 py-1 text-sm rounded {{ $chartType === 'bar' ? 'bg-blue-100 text-blue-700' : 'text-gray-500 hover:text-gray-700' }}"
                            >
                                <i class="fas fa-chart-bar mr-1"></i> Bar
                            </button>
                        </div>
                        
                        <!-- Time Period Selector -->
                       

                        <!-- User Type Filter -->
                        <select 
                            wire:model="userTypeFilter" 
                            wire:change="updateUserTypeFilter($event.target.value)"
                            class="text-sm border border-gray-200 rounded-lg px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="all">All Users</option>
                            <option value="student">Students Only</option>
                            <option value="staff">Staff Only</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <canvas id="registrationChart-{{ $this->getId() }}" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Role Distribution Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Role Distribution</h3>
            </div>
            <div class="p-6">
                <canvas id="roleChart-{{ $this->getId() }}" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

  


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const componentId = '{{ $this->getId() }}';
        
        // Registration Chart
        const registrationData = @json($registrationData);
        const chartType = '{{ $chartType }}';
        
        const ctx1 = document.getElementById('registrationChart-' + componentId).getContext('2d');
        window.registrationChart = new Chart(ctx1, {
            type: chartType,
            data: {
                labels: registrationData.map(item => item.label),
                datasets: [{
                    label: 'New Registrations',
                    data: registrationData.map(item => item.value),
                    backgroundColor: chartType === 'line' ? 'rgba(59, 130, 246, 0.1)' : 'rgba(59, 130, 246, 0.8)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 2,
                    fill: chartType === 'bar',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Role Distribution Chart
        const roleData = @json($roleDistribution);
        const ctx2 = document.getElementById('roleChart-' + componentId).getContext('2d');
        window.roleChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: roleData.map(item => item.role_name),
                datasets: [{
                    data: roleData.map(item => item.count),
                    backgroundColor: roleData.map(item => item.color || '#3B82F6')
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    });

    // Listen for Livewire updates
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', (message, component) => {
            if (component.fingerprint.name === 'backend.staff.card') {
                // Destroy existing charts before recreating
                if (window.registrationChart) {
                    window.registrationChart.destroy();
                }
                if (window.roleChart) {
                    window.roleChart.destroy();
                }
                
                // Small delay to ensure DOM is updated
                setTimeout(() => {
                    window.location.reload();
                }, 100);
            }
        });
    });
</script>
</div>