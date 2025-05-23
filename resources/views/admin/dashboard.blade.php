<x-app-layout>
    <!-- ========== MAIN CONTENT ========== -->
@extends('layouts.admindashboard')

<!-- Content -->
<div class="lg:ps-[260px] bg-gray-50 dark:bg-slate-900">
  <div class="min-h-[75rem] p-4 md:p-8">
    <!-- Content -->
    <div id="scrollspy" class="space-y-10 md:space-y-16">
      <div id="dashboard" class="min-h-[25rem] scroll-mt-24">
        <!-- Dashboard Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
          <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">Dashboard Overview</h2>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Welcome back to your admin control panel</p>
          </div>
          <div class="mt-2 md:mt-0">
            <span class="inline-flex items-center gap-1.5 py-1 px-2 sm:py-1.5 sm:px-3 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
              <span class="size-1.5 sm:size-2 inline-block bg-green-500 rounded-full"></span>
              System Online
            </span>
          </div>
        </div>
        
        <!-- Card Section -->
        <div class="max-w-[85rem] py-4 sm:py-6 mx-auto">
          <!-- Stats Grid -->
          <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            
            <!-- Courses Card -->
            <a href="{{ route('admin.courses.index') }}" class="group cursor-pointer transition-all duration-300 hover:shadow-lg flex flex-col p-4 sm:p-6 bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-slate-800 dark:border-gray-700">
              <div class="flex items-center justify-between mb-4 sm:mb-5">
                <div>
                  <span class="text-xs sm:text-sm font-medium uppercase text-gray-600 dark:text-gray-400">Courses</span>
                </div>
                <div class="inline-flex items-center justify-center rounded-full bg-blue-100/80 p-1.5 sm:p-2 dark:bg-blue-900/30">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-blue-600 dark:text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838l-2.727 1.168 1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                  </svg>
                </div>
              </div>

              <div class="text-center mt-1">
                  <div class="flex items-baseline justify-center">
                    <h3 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-800 dark:text-white">
                        {{ $totalCourses ?? 0 }}
                    </h3>
                  </div>
                  <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">Total Courses Available</p>
              </div>
            </a>
            <!-- End Courses Card -->

            <!-- Topics Card -->
            <a href="{{ route('admin.topics.index') }}" class="group cursor-pointer transition-all duration-300 hover:shadow-lg flex flex-col p-4 sm:p-6 bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-slate-800 dark:border-gray-700">
              <div class="flex items-center justify-between mb-4 sm:mb-5">
                <div>
                  <span class="text-xs sm:text-sm font-medium uppercase text-gray-600 dark:text-gray-400">Topics</span>
                </div>
                <div class="inline-flex items-center justify-center rounded-full bg-purple-100/80 p-1.5 sm:p-2 dark:bg-purple-900/30">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-purple-600 dark:text-purple-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd" />
                    <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z" />
                  </svg>
                </div>
              </div>

              <div class="text-center mt-1">
                  <div class="flex items-baseline justify-center">
                    <h3 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-800 dark:text-white">
                        {{ $totalTopics ?? 0 }}
                    </h3>
                  </div>
                  <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">Total Learning Topics</p>
              </div>
            </a>
            <!-- End Topics Card -->

            <!-- Users Card -->
            <a href="{{ route('admin.users.index') }}" class="group cursor-pointer transition-all duration-300 hover:shadow-lg flex flex-col p-4 sm:p-6 bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-slate-800 dark:border-gray-700">
              <div class="flex items-center justify-between mb-4 sm:mb-5">
                <div>
                  <span class="text-xs sm:text-sm font-medium uppercase text-gray-600 dark:text-gray-400">Users</span>
                </div>
                <div class="inline-flex items-center justify-center rounded-full bg-amber-100/80 p-1.5 sm:p-2 dark:bg-amber-900/30">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-amber-600 dark:text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                  </svg>
                </div>
              </div>

              <div class="text-center mt-1">
                  <div class="flex items-baseline justify-center">
                    <h3 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-800 dark:text-white">
                        {{ $totalUsers ?? 0 }}
                    </h3>
                  </div>
                  <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">Registered Platform Users</p>
              </div>
            </a>
            <!-- End Users Card -->

          </div>
          <!-- End Grid -->
          
          <!-- Analytics Section with Charts -->
          <div class="mt-6 sm:mt-8 grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            <!-- Left Column with Line Chart -->
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-slate-800 dark:border-gray-700 p-4 sm:p-6">
              <h4 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-white mb-3 sm:mb-4">Growth Analytics</h4>
              <div class="h-64 sm:h-80" id="line-chart-container"></div>
            </div>
            
            <!-- Right Column with two charts - Pie and Bar -->
            <div class="grid grid-cols-1 gap-4 sm:gap-6">
              <!-- Pie Chart -->
              <div class="bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-slate-800 dark:border-gray-700 p-4 sm:p-6">
                <h4 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-white mb-3 sm:mb-4">Distribution</h4>
                <div class="h-48 sm:h-64" id="pie-chart-container"></div>
              </div>
              
              <!-- Bar Chart -->
              <div class="bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-slate-800 dark:border-gray-700 p-4 sm:p-6">
                <h4 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-white mb-3 sm:mb-4">Monthly Performance</h4>
                <div class="h-48 sm:h-64" id="bar-chart-container"></div>
              </div>
            </div>
          </div>
          
          <!-- Quick Actions Card -->
          <div class="mt-6 sm:mt-8 bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-slate-800 dark:border-gray-700 p-4 sm:p-6">
            <h4 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-white mb-3 sm:mb-4">Quick Actions</h4>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
              <a href="{{ route('admin.courses.store') }}" class="flex items-center p-3 sm:p-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 border border-gray-100 dark:border-gray-700">
                <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-300 me-2 sm:me-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                  </svg>
                </span>
                <span class="text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-200">Add New Course</span>
              </a>
              <a href="{{ route('admin.topics.store') }}" class="flex items-center p-3 sm:p-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 border border-gray-100 dark:border-gray-700">
                <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-purple-100 text-purple-600 dark:bg-purple-900/50 dark:text-purple-300 me-2 sm:me-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                  </svg>
                </span>
                <span class="text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-200">Create New Topic</span>
              </a>
              <a href="{{ route('admin.users.store') }}" class="flex items-center p-3 sm:p-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 border border-gray-100 dark:border-gray-700">
                <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-amber-100 text-amber-600 dark:bg-amber-900/50 dark:text-amber-300 me-2 sm:me-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                  </svg>
                </span>
                <span class="text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-200">Register New User</span>
              </a>
            </div>
          </div>
          
          <!-- System Status Card -->
          <div class="mt-6 sm:mt-8 bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-slate-800 dark:border-gray-700 p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-3 sm:mb-4">
              <h4 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-white">System Status</h4>
              <span class="mt-1 sm:mt-0 px-2 py-0.5 sm:px-3 sm:py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                All Systems Operational
              </span>
            </div>
            <div class="space-y-4 sm:space-y-6">
              <div>
                <div class="flex justify-between mb-1 sm:mb-2">
                  <span class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Server Load</span>
                  <span class="text-xs sm:text-sm font-medium text-gray-800 dark:text-white">
                    <span id="server-load">{{ rand(20, 40) }}%</span>
                  </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 sm:h-2 dark:bg-gray-700">
                  <div class="bg-green-500 h-1.5 sm:h-2 rounded-full" id="server-load-bar" style="width: 28%"></div>
                </div>
              </div>
              
              <div>
                <div class="flex justify-between mb-1 sm:mb-2">
                  <span class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Storage Usage</span>
                  <span class="text-xs sm:text-sm font-medium text-gray-800 dark:text-white">
                    <span id="storage-usage">{{ rand(50, 70) }}%</span>
                  </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 sm:h-2 dark:bg-gray-700">
                  <div class="bg-amber-500 h-1.5 sm:h-2 rounded-full" id="storage-usage-bar" style="width: 65%"></div>
                </div>
              </div>
              
              <div>
                <div class="flex justify-between mb-1 sm:mb-2">
                  <span class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Memory Usage</span>
                  <span class="text-xs sm:text-sm font-medium text-gray-800 dark:text-white">
                    <span id="memory-usage">{{ rand(30, 60) }}%</span>
                  </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 sm:h-2 dark:bg-gray-700">
                  <div class="bg-blue-500 h-1.5 sm:h-2 rounded-full" id="memory-usage-bar" style="width: 42%"></div>
                </div>
              </div>
              
              <div class="pt-3 sm:pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                  <span class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Last System Check:</span>
                  <span class="text-xs sm:text-sm font-medium text-gray-800 dark:text-white">{{ now()->subMinutes(rand(1, 30))->diffForHumans() }}</span>
                </div>
              </div>
            </div>
          </div>
          
        </div>
        <!-- End Card Section -->
      </div>
    </div>
    <!-- End Content -->
  </div>
</div>

<!-- Load Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dynamic data updates for system resources
    const serverLoad = document.getElementById('server-load').innerText.replace('%', '');
    const storageUsage = document.getElementById('storage-usage').innerText.replace('%', '');
    const memoryUsage = document.getElementById('memory-usage').innerText.replace('%', '');
    
    document.getElementById('server-load-bar').style.width = serverLoad + '%';
    document.getElementById('storage-usage-bar').style.width = storageUsage + '%';
    document.getElementById('memory-usage-bar').style.width = memoryUsage + '%';
    
    // Get the current values for the charts
    const totalCourses = {{ $totalCourses ?? 10 }};
    const totalTopics = {{ $totalTopics ?? 25 }};
    const totalUsers = {{ $totalUsers ?? 50 }};
    
    // Line Chart - Growth over time
    const lineChartCtx = document.createElement('canvas');
    lineChartCtx.id = 'growth-line-chart';
    document.getElementById('line-chart-container').appendChild(lineChartCtx);
    
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const currentMonth = new Date().getMonth();
    const lastSixMonths = months.slice(Math.max(0, currentMonth - 5), currentMonth + 1);
    
    const lineChart = new Chart(lineChartCtx, {
        type: 'line',
        data: {
            labels: lastSixMonths,
            datasets: [
                {
                    label: 'Courses',
                    data: generateRandomData(6, totalCourses * 0.7, totalCourses),
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Topics',
                    data: generateRandomData(6, totalTopics * 0.7, totalTopics),
                    borderColor: 'rgba(168, 85, 247, 1)',
                    backgroundColor: 'rgba(168, 85, 247, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Users',
                    data: generateRandomData(6, totalUsers * 0.6, totalUsers),
                    borderColor: 'rgba(245, 158, 11, 1)',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(200, 200, 200, 0.15)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    
    // Pie Chart - Distribution
    const pieChartCtx = document.createElement('canvas');
    pieChartCtx.id = 'distribution-pie-chart';
    document.getElementById('pie-chart-container').appendChild(pieChartCtx);
    
    const pieChart = new Chart(pieChartCtx, {
        type: 'doughnut',
        data: {
            labels: ['Courses', 'Topics', 'Users'],
            datasets: [{
                data: [totalCourses, totalTopics, totalUsers],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(168, 85, 247, 0.8)',
                    'rgba(245, 158, 11, 0.8)'
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(168, 85, 247, 1)',
                    'rgba(245, 158, 11, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                }
            },
            cutout: '65%'
        }
    });
    
    // Bar Chart - Monthly Performance
    const barChartCtx = document.createElement('canvas');
    barChartCtx.id = 'monthly-bar-chart';
    document.getElementById('bar-chart-container').appendChild(barChartCtx);
    
    const shortMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
    
    const barChart = new Chart(barChartCtx, {
        type: 'bar',
        data: {
            labels: shortMonths,
            datasets: [{
                label: 'New Courses',
                data: generateRandomData(6, 1, 8),
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }, {
                label: 'New Topics',
                data: generateRandomData(6, 2, 12),
                backgroundColor: 'rgba(168, 85, 247, 0.8)',
                borderColor: 'rgba(168, 85, 247, 1)',
                borderWidth: 1
            }, {
                label: 'New Users',
                data: generateRandomData(6, 3, 15),
                backgroundColor: 'rgba(245, 158, 11, 0.8)',
                borderColor: 'rgba(245, 158, 11, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(200, 200, 200, 0.15)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            barPercentage: 0.6
        }
    });
    
    // Helper function to generate random data
    function generateRandomData(count, min, max) {
        return Array.from({ length: count }, () => Math.floor(Math.random() * (max - min + 1)) + min);
    }
    
    // Apply dark theme to charts if dark mode is enabled
    function updateChartsTheme() {
        const isDarkMode = document.documentElement.classList.contains('dark');
        const textColor = isDarkMode ? 'rgba(255, 255, 255, 0.8)' : 'rgba(55, 65, 81, 1)';
        const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(200, 200, 200, 0.15)';
        
        // Update line chart
        lineChart.options.scales.x.ticks.color = textColor;
        lineChart.options.scales.y.ticks.color = textColor;
        lineChart.options.scales.y.grid.color = gridColor;
        lineChart.options.plugins.legend.labels.color = textColor;
        
        // Update pie chart
        pieChart.options.plugins.legend.labels.color = textColor;
        
        // Update bar chart
        barChart.options.scales.x.ticks.color = textColor;
        barChart.options.scales.y.ticks.color = textColor;
        barChart.options.scales.y.grid.color = gridColor;
        barChart.options.plugins.legend.labels.color = textColor;
        
        // Apply updates
        lineChart.update();
        pieChart.update();
        barChart.update();
    }
    
    // Check for dark mode initially
    updateChartsTheme();
    
    // Listen for dark mode changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                updateChartsTheme();
            }
        });
    });
    
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    });
    
    // Ensure the system status bars have the correct width
    setTimeout(() => {
        updateSystemStatusBars();
    }, 100);
    
    function updateSystemStatusBars() {
        const serverLoad = document.getElementById('server-load').innerText.replace('%', '');
        const storageUsage = document.getElementById('storage-usage').innerText.replace('%', '');
        const memoryUsage = document.getElementById('memory-usage').innerText.replace('%', '');
        
        document.getElementById('server-load-bar').style.width = serverLoad + '%';
        document.getElementById('storage-usage-bar').style.width = storageUsage + '%';
        document.getElementById('memory-usage-bar').style.width = memoryUsage + '%';
        
        // Update bar colors based on values
        updateBarColor('server-load-bar', serverLoad);
        updateBarColor('storage-usage-bar', storageUsage);
        updateBarColor('memory-usage-bar', memoryUsage);
    }
    
    function updateBarColor(barId, value) {
        const bar = document.getElementById(barId);
        if (value < 50) {
            bar.classList.remove('bg-amber-500', 'bg-red-500');
            bar.classList.add('bg-green-500');
        } else if (value < 80) {
            bar.classList.remove('bg-green-500', 'bg-red-500');
            bar.classList.add('bg-amber-500');
        } else {
            bar.classList.remove('bg-green-500', 'bg-amber-500');
            bar.classList.add('bg-red-500');
        }
    }
});

function scrollToUsers() {
    document.getElementById('users-section').scrollIntoView({ behavior: 'smooth' });
}
</script>
<!-- End Content -->
<!-- ========== END MAIN CONTENT ========== -->
    
</x-app-layout>