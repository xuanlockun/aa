<div>
    <div class="max-w-7xl mx-auto p-6 rounded shadow">
        {{-- Thêm badge nhỏ để biết dữ liệu từ cache hay không --}}
        <div class="mb-4 flex justify-end">
            @if($fromCache)
                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">
                    📦 Dữ liệu từ cache
                </span>
            @else
                <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded">
                    🔄 Dữ liệu mới
                </span>
            @endif
            
            {{-- Nút refresh thủ công (nếu muốn) --}}
            <button 
                wire:click="forceRefresh" 
                wire:loading.attr="disabled"
                class="ml-2 text-xs bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded"
            >
                <span wire:loading.remove>⟳ Refresh</span>
                <span wire:loading>Đang refresh...</span>
            </button>
        </div>

        <h2 class="text-2xl font-bold mb-6 text-center">
            Thống kê phổ điểm theo môn
        </h2>

        {{-- Chart --}}
        <div wire:ignore style="height:400px;">
            <canvas id="scoreChart"></canvas>
        </div>

        {{-- Table --}}
        <table class="w-full border text-center mt-10">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Môn</th>
                    <th class="p-2">≥ 8</th>
                    <th class="p-2">6 - < 8</th>
                    <th class="p-2">4 - < 6</th>
                    <th class="p-2">< 4</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report as $subject => $levels)
                    <tr class="border-t">
                        <td class="p-2 font-medium">
                            {{ ucfirst(str_replace('_',' ', $subject)) }}
                        </td>
                        <td>{{ number_format($levels['>=8']) }}</td>
                        <td>{{ number_format($levels['6-8']) }}</td>
                        <td>{{ number_format($levels['4-6']) }}</td>
                        <td>{{ number_format($levels['<4']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @push('scripts')
    <script>
    document.addEventListener("livewire:navigated", function() {
        setTimeout(initChart, 100);
    });

    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(initChart, 100);
    });

    document.addEventListener("livewire:init", function() {
        Livewire.on('report-updated', function() {
            setTimeout(initChart, 100);
        });
    });

    function initChart() {
        let reportData;
        try {
            reportData = @json($report);
        } catch(e) {
            console.error('Error parsing report data:', e);
            return;
        }
        
        if (!reportData || Object.keys(reportData).length === 0) {
            console.log('No data available');
            return;
        }
        
        const canvas = document.getElementById('scoreChart');
        if (!canvas) {
            console.log('Canvas element not found');
            return;
        }

        if (window.scoreChart instanceof Chart) {
            window.scoreChart.destroy();
            window.scoreChart = null;
        }

        const subjects = Object.keys(reportData);
        if (subjects.length === 0) {
            console.log('No subjects found');
            return;
        }

        try {
            const formattedSubjects = subjects.map(s => {
                return s.split('_')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');
            });

            window.scoreChart = new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: formattedSubjects,
                    datasets: [
                        {
                            label: '≥ 8',
                            data: subjects.map(s => Number(reportData[s]['>=8'] || 0)),
                            backgroundColor: '#22c55e'
                        },
                        {
                            label: '6 - < 8',
                            data: subjects.map(s => Number(reportData[s]['6-8'] || 0)),
                            backgroundColor: '#3b82f6'
                        },
                        {
                            label: '4 - < 6',
                            data: subjects.map(s => Number(reportData[s]['4-6'] || 0)),
                            backgroundColor: '#f59e0b'
                        },
                        {
                            label: '< 4',
                            data: subjects.map(s => Number(reportData[s]['<4'] || 0)),
                            backgroundColor: '#ef4444'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' }
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
            
            console.log('Chart initialized successfully');
        } catch (error) {
            console.error('Error initializing chart:', error);
        }
    }
    </script>
    @endpush
</div>