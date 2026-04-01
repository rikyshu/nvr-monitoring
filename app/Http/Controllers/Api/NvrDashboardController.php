<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NvrEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class NvrDashboardController extends Controller
{
    /**
     * Get summary metrics for the dashboard.
     */
    public function getSummary()
    {
        $today = Carbon::today();

        // Total movements today
        $totalMovements = NvrEvent::whereDate('detected_at', $today)->count();

        // Peak Activity Hour
        $peakHourRecord = NvrEvent::whereDate('detected_at', $today)
            ->select(DB::raw('EXTRACT(HOUR FROM detected_at) as hour'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('EXTRACT(HOUR FROM detected_at)'))
            ->orderByDesc('total')
            ->first();
        
        $peakHourStr = $peakHourRecord 
            ? sprintf("%02d:00 - %02d:00", $peakHourRecord->hour, $peakHourRecord->hour + 1)
            : '-';

        // Most Active Camera
        $mostActiveCameraRecord = NvrEvent::whereDate('detected_at', $today)
            ->select('camera_name', DB::raw('count(*) as total'))
            ->groupBy('camera_name')
            ->orderByDesc('total')
            ->first();

        $activeCamera = $mostActiveCameraRecord ? $mostActiveCameraRecord->camera_name : 'Belum Ada Data';

        return response()->json([
            'total_gerakan_hari_ini' => $totalMovements,
            'jam_puncak' => $peakHourStr,
            'kamera_teraktif' => $activeCamera,
            'penyimpanan_tersedia' => '75% (2.3 TB)', // Simulated disk space for now
            'status_nvr' => 'Online',
            'terakhir_sinkron' => now()->format('H:i')
        ]);
    }

    /**
     * Get time series data for the main chart based on filter.
     */
    public function getChartData(Request $request)
    {
        $filter = $request->query('filter', 'today');
        
        $chartSeries = [];
        $labels = [];

        if ($filter === 'this_month') {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $daysInMonth = $endOfMonth->day;

            $dailyData = NvrEvent::whereBetween('detected_at', [$startOfMonth, $endOfMonth])
                ->select(DB::raw('DATE(detected_at) as date'), DB::raw('count(*) as total'))
                ->groupBy(DB::raw('DATE(detected_at)'))
                ->get()
                ->keyBy('date');

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $dateStr = $startOfMonth->copy()->addDays($i - 1)->format('Y-m-d');
                $labels[] = $i . ' ' . $startOfMonth->format('M');
                $chartSeries[] = isset($dailyData[$dateStr]) ? $dailyData[$dateStr]->total : 0;
            }
        } elseif ($filter === '7_days') {
            $startDate = Carbon::today()->subDays(6);
            
            $dailyData = NvrEvent::whereDate('detected_at', '>=', $startDate)
                ->select(DB::raw('DATE(detected_at) as date'), DB::raw('count(*) as total'))
                ->groupBy(DB::raw('DATE(detected_at)'))
                ->get()
                ->keyBy('date');

            for ($i = 0; $i < 7; $i++) {
                $date = $startDate->copy()->addDays($i);
                $dateStr = $date->format('Y-m-d');
                $labels[] = $date->format('d M');
                $chartSeries[] = isset($dailyData[$dateStr]) ? $dailyData[$dateStr]->total : 0;
            }
        } else {
            // Default: 'today'
            $today = Carbon::today();
            $hourlyData = NvrEvent::whereDate('detected_at', $today)
                ->select(DB::raw('EXTRACT(HOUR FROM detected_at) as hour'), DB::raw('count(*) as total'))
                ->groupBy(DB::raw('EXTRACT(HOUR FROM detected_at)'))
                ->get()
                ->keyBy('hour');

            for ($i = 0; $i < 24; $i++) {
                $formattedHourStr = sprintf("%02d:00", $i);
                $labels[] = $formattedHourStr;
                $chartSeries[] = isset($hourlyData[$i]) ? $hourlyData[$i]->total : 0;
            }
        }

        return response()->json([
            'labels' => $labels,
            'series' => $chartSeries,
        ]);
    }

    /**
     * Get paginated recent event logs.
     */
    public function getRecentLogs()
    {
        $logs = NvrEvent::orderBy('detected_at', 'desc')
            ->paginate(10)
            ->through(function ($event) {
                return [
                    'id' => $event->id,
                    'timestamp' => $event->detected_at->format('Y-m-d H:i:s'),
                    'camera_name' => $event->camera_name,
                    'event_type' => $event->event_type,
                    'snapshot_path' => $event->snapshot_path,
                ];
            });

        return response()->json($logs);
    }

    /**
     * Get unique cameras and their live statuses.
     */
    public function getCameras()
    {
        // Get the latest event for each unique camera ID
        $camerasDB = NvrEvent::select('camera_id', 'camera_name', DB::raw('MAX(detected_at) as last_seen'))
            ->groupBy('camera_id', 'camera_name')
            ->get();

        $cameras = $camerasDB->map(function ($cam) {
            // If seen within last 24 hours, count as LIVE, else ERROR
            $lastSeenDate = Carbon::parse($cam->last_seen);
            $isLive = $lastSeenDate->diffInHours(now()) <= 24;

            return [
                'camera_id' => $cam->camera_id,
                'camera_name' => $cam->camera_name,
                'status' => $isLive ? 'LIVE' : 'ERROR',
            ];
        });

        // If no records at all, we could provide some dummy payload to match the mockup
        if ($cameras->isEmpty()) {
            $cameras = collect([
                ['camera_id' => '1', 'camera_name' => 'IPDome 1 (Halaman)', 'status' => 'LIVE'],
                ['camera_id' => '2', 'camera_name' => 'IPDome 2 (Kasir)', 'status' => 'ERROR'],
                ['camera_id' => 'nvr1', 'camera_name' => 'NVR Utama (DS-7604NI)', 'status' => 'LIVE'],
            ]);
        }

        return response()->json($cameras);
    }
}
