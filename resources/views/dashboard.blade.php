<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 relative z-20">
            <h2 class="font-bold text-2xl text-blue-900 dark:text-gray-200 leading-tight">
                Dashboard Analitik Pergerakan NVR
            </h2>
            <div class="bg-blue-50 text-blue-800 px-5 py-2 rounded-full font-medium text-sm border border-blue-200 flex items-center shadow-sm">
                Status NVR: <span class="ml-2 w-3 h-3 bg-emerald-500 rounded-full inline-block animate-pulse"></span>
                <span class="ml-1 text-emerald-600 font-bold">Online</span> 
                <span class="ml-1 text-gray-500 font-normal" id="sync-time">(Terakhir Sinkron: --:--)</span>
            </div>
        </div>
    </x-slot>

    <!-- Top background blue section -->
    <div class="absolute top-0 w-full h-72 bg-gradient-to-r from-blue-900 to-blue-700 z-0 hidden lg:block"></div>

    <div class="py-8 relative min-h-screen" x-data="dashboardData()" x-init="fetchData()">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <!-- 4 Top Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <!-- Card 1 -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 p-6 border border-gray-100 flex items-center relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-blue-50 rounded-full opacity-50 z-0"></div>
                    <div class="rounded-xl bg-blue-50 p-4 mr-4 text-blue-600 relative z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Total Gerakan Hari Ini</p>
                        <h3 class="text-3xl font-extrabold text-gray-800" x-text="summary.total_gerakan_hari_ini">0</h3>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 p-6 border border-gray-100 flex items-center relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-indigo-50 rounded-full opacity-50 z-0"></div>
                    <div class="rounded-xl bg-indigo-50 p-4 mr-4 text-indigo-600 relative z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Jam Puncak Aktivitas</p>
                        <h3 class="text-xl font-extrabold text-gray-800" x-text="summary.jam_puncak">--:--</h3>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 p-6 border border-gray-100 flex items-center relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-teal-50 rounded-full opacity-50 z-0"></div>
                    <div class="rounded-xl bg-teal-50 p-4 mr-4 text-teal-600 relative z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="relative z-10 w-full">
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Kamera Teraktif</p>
                        <h3 class="text-lg font-extrabold text-gray-800 truncate w-full max-w-[150px]" x-text="summary.kamera_teraktif">Memuat...</h3>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 p-6 border border-gray-100 flex items-center relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-sky-50 rounded-full opacity-50 z-0"></div>
                    <div class="rounded-xl bg-sky-50 p-4 mr-4 text-sky-600 relative z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Storage NVR</p>
                        <h3 class="text-xl font-extrabold text-gray-800" x-text="summary.penyimpanan_tersedia">0%</h3>
                    </div>
                </div>
            </div>

            <!-- Main Grid Layout -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                
                <!-- Kiri: Area Chart & Log Aktivitas -->
                <div class="xl:col-span-2 flex flex-col gap-8">
                    <!-- Area Chart -->
                    <div class="bg-white rounded-2xl shadow-sm p-7 border border-gray-100 flex-1 relative overflow-hidden">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-800">Tren Aktivitas Pergerakan (Hari Ini)</h3>
                            <div class="bg-gray-100 px-3 py-1 rounded-md text-xs font-semibold text-gray-500 mt-2 sm:mt-0">Sumbu Y: Jumlah Pergerakan</div>
                        </div>
                        <div class="relative h-80 w-full mt-2">
                            <canvas id="nvrChart"></canvas>
                        </div>
                    </div>

                    <!-- Tabel Log Aktivitas -->
                    <div class="bg-white rounded-2xl shadow-sm p-7 border border-gray-100 overflow-hidden">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Log Aktivitas Langsung (Real-time)</h3>
                        <div class="overflow-x-auto rounded-xl border border-gray-100">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="text-xs text-gray-500 bg-gray-50 uppercase font-bold tracking-wider">
                                    <tr>
                                        <th class="px-5 py-4 w-24">Waktu</th>
                                        <th class="px-5 py-4">Nama Kamera</th>
                                        <th class="px-5 py-4 w-48">Jenis Kejadian</th>
                                        <th class="px-5 py-4 text-center">Snapshot</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                    <template x-for="log in recentLogs" :key="log.id">
                                        <tr class="hover:bg-blue-50/30 transition-colors">
                                            <td class="px-5 py-4">
                                                <span class="font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded" x-text="log.timestamp"></span>
                                            </td>
                                            <td class="px-5 py-4 font-medium text-gray-700" x-text="log.camera_name"></td>
                                            <td class="px-5 py-4">
                                                <span 
                                                    class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs font-semibold whitespace-nowrap" 
                                                    x-text="log.event_type.replace('_', ' ')">
                                                </span>
                                            </td>
                                            <td class="px-5 py-4 text-center">
                                                <template x-if="log.snapshot_path">
                                                    <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                        Lihat
                                                    </a>
                                                </template>
                                                <template x-if="!log.snapshot_path">
                                                    <span class="text-gray-300">-</span>
                                                </template>
                                            </td>
                                        </tr>
                                    </template>
                                    <!-- Empty state -->
                                    <tr x-show="recentLogs.length === 0">
                                        <td colspan="4" class="px-5 py-8 text-center text-gray-400 italic">Belum ada aktivitas terekam.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Daftar Kamera & Status -->
                <div class="xl:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm p-7 border border-gray-100 h-full">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Daftar Kamera NVR
                        </h3>
                        <div class="space-y-4">
                            <template x-for="cam in cameras" :key="cam.camera_id">
                                <div class="p-4 border border-gray-100 rounded-xl hover:shadow-md transition-shadow bg-gray-50/50 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-14 h-12 bg-gray-200 rounded-lg overflow-hidden relative mr-4 shadow-sm border border-gray-200">
                                            <!-- Dummy Camera Thumb -->
                                            <img src="https://images.unsplash.com/photo-1557053964-937650ddc8a2?auto=format&fit=crop&w=150&q=80" alt="Camera View" class="w-full h-full object-cover">
                                            <div class="absolute top-0 right-0 bg-green-500 text-white text-[9px] px-1 m-0.5 rounded-sm font-bold shadow" x-show="cam.status === 'LIVE'">REC</div>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-800 leading-tight mb-1" x-text="cam.camera_name"></h4>
                                            <p class="text-[11px] font-medium text-gray-500 bg-white px-1.5 py-0.5 rounded border border-gray-200 inline-block" x-text="cam.camera_id"></p>
                                        </div>
                                    </div>
                                    <span 
                                        :class="cam.status === 'LIVE' ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 'bg-rose-100 text-rose-700 border-rose-200'" 
                                        class="px-2.5 py-1 rounded-md text-[11px] font-black uppercase tracking-wider border shadow-sm" 
                                        x-text="cam.status">
                                    </span>
                                </div>
                            </template>
                            
                            <!-- Empty state -->
                            <div x-show="cameras.length === 0" class="text-center py-8 text-gray-400 text-sm">
                                Mengambil daftar kamera...
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Script Block for Alpine.js & Chart.js -->
    <script>
        function dashboardData() {
            return {
                summary: {
                    total_gerakan_hari_ini: 0,
                    jam_puncak: '--:--',
                    kamera_teraktif: '-',
                    penyimpanan_tersedia: '-'
                },
                recentLogs: [],
                cameras: [],
                
                async fetchData() {
                    try {
                        const [summaryRes, chartRes, logsRes, camRes] = await Promise.all([
                            fetch('/api/nvr/summary'),
                            fetch('/api/nvr/chart-data'),
                            fetch('/api/nvr/recent-logs'),
                            fetch('/api/nvr/cameras')
                        ]);

                        this.summary = await summaryRes.json();
                        this.recentLogs = await logsRes.json();
                        this.cameras = await camRes.json();
                        
                        document.getElementById('sync-time').innerText = `(Terakhir Sinkron: ${this.summary.terakhir_sinkron})`;

                        // Init Chart
                        const chartData = await chartRes.json();
                        
                        // Wait for window.Chart to be available if vite is slow
                        let checks = 0;
                        const checkChart = setInterval(() => {
                            if(window.Chart) {
                                clearInterval(checkChart);
                                this.initChart(chartData.labels, chartData.series);
                            }
                            if(checks++ > 20) clearInterval(checkChart); // Timeout
                        }, 100);

                    } catch (error) {
                        console.error("Gagal mengambil data dari API NVR:", error);
                    }
                },
                
                initChart(labels, series) {
                    const ctx = document.getElementById('nvrChart').getContext('2d');
                    
                    // Membuat efek gradient fill keren ala mockup
                    let gradient = ctx.createLinearGradient(0, 0, 0, 350);
                    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.6)');   // Indigo-ish
                    gradient.addColorStop(0.5, 'rgba(59, 130, 246, 0.3)'); // Blue-ish
                    gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');   // Fade out
                    
                    if (window.nvrChartInst) { window.nvrChartInst.destroy(); }
                    
                    window.nvrChartInst = new window.Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Gerakan (Aktivitas)',
                                data: series,
                                borderColor: '#4f46e5', // Indigo 600
                                backgroundColor: gradient,
                                fill: true,
                                tension: 0.45, // Membuat garis sangat mulus (curviness)
                                borderWidth: 3,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#4f46e5',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                pointHoverBackgroundColor: '#4f46e5',
                                pointHoverBorderColor: '#ffffff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                intersect: false,
                                mode: 'index',
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: 'rgba(17, 24, 39, 0.9)',
                                    padding: 12,
                                    titleFont: { size: 13 },
                                    bodyFont: { size: 14, weight: 'bold' },
                                    displayColors: false,
                                    cornerRadius: 8,
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { color: '#f3f4f6', drawBorder: false },
                                    ticks: { color: '#9ca3af', font: { size: 11 }, padding: 10 }
                                },
                                x: {
                                    grid: { display: false, drawBorder: false },
                                    ticks: { color: '#9ca3af', font: { size: 11 }, maxTicksLimit: 12, padding: 10 } // Tampilkan setiap ~2 jam
                                }
                            }
                        }
                    });
                }
            }
        }
    </script>
</x-app-layout>
