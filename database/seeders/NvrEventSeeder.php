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
            
            NvrEvent::create([
                'camera_id' => $cam['id'],
                'camera_name' => $cam['name'],
                'event_type' => $type,
                'detected_at' => $today->copy()->setTime($hour, $minute),
                'snapshot_path' => null,
                'metadata' => [
                    'source' => 'Seeder'
                ],
            ]);
        }
    }
}
