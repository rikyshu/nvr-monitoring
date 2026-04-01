<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NvrEvent;
use Illuminate\Support\Carbon;

class NvrEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NvrEvent::truncate();

        $cameras = [
            ['id' => 'CAM-01', 'name' => 'Gudang Belakang'],
            ['id' => 'CAM-02', 'name' => 'Area Parkir'],
            ['id' => 'CAM-03', 'name' => 'Pagar Depan'],
            ['id' => 'CAM-04', 'name' => 'Lobi Utama'],
        ];

        $eventTypes = ['motion_detected', 'line_crossing', 'face_detected'];

        $today = Carbon::today();
        
        for ($i = 0; $i < 450; $i++) {
            $cam = $cameras[array_rand($cameras)];
            $type = $eventTypes[array_rand($eventTypes)];
            
            // Random hour distributed to simulate a peak around 14:00-18:00
            $hour = rand(0, 100) > 60 ? rand(13, 18) : rand(0, 23);
            $minute = rand(0, 59);
            
            $hasSnapshot = rand(0, 100) > 30; // 70% chance of having a snapshot
            $dummyImages = [
                'https://images.unsplash.com/photo-1557053964-937650ddc8a2?auto=format&fit=crop&w=600&q=80', // CCTV dummy 1
                'https://images.unsplash.com/photo-1518314916381-77a37c2a49ae?auto=format&fit=crop&w=600&q=80', // CCTV dummy 2
                'https://images.unsplash.com/photo-1517036725332-9cb4d2f1f501?auto=format&fit=crop&w=600&q=80', // CCTV dummy 3
                'https://images.unsplash.com/photo-1557053964-1678dc803274?auto=format&fit=crop&w=600&q=80', // CCTV dummy 4
            ];

            NvrEvent::create([
                'camera_id' => $cam['id'],
                'camera_name' => $cam['name'],
                'event_type' => $type,
                'detected_at' => $today->copy()->setTime($hour, $minute),
                'snapshot_path' => $hasSnapshot ? $dummyImages[array_rand($dummyImages)] : null,
                'metadata' => [
                    'source' => 'Seeder'
                ],
            ]);
        }
    }
}
