<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NvrEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NvrWebhookController extends Controller
{
    /**
     * Endpoint to receive alerts from Hikvision DS-7604NI NVR.
     */
    public function receiveEvent(Request $request)
    {
        // 1. Validasi Keamanan (Secure Webhook)
        // Mengecek apakah Request memiliki Token yang cocok dengan environment variable
        $expectedToken = env('HIKVISION_API_TOKEN', 'default-secure-token');
        $providedToken = $request->header('Authorization') ?: $request->query('token');

        if ($providedToken !== "Bearer {$expectedToken}" && $providedToken !== $expectedToken) {
            Log::warning('NVR Webhook: Unauthorized access attempt.');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // 2. Extract Metadata (Flexible for JSON & XML)
        $payload = $request->all();
        $rawContent = $request->getContent();

        // Mencoba mengambil data dasar (bisa disesuaikan setelah melihat format asli Hikvision)
        $cameraId = $request->input('macAddress', 'HIKVISION-NVR-1');
        $cameraName = $request->input('channelName', 'Kamera Belum Diset');
        $eventType = $request->input('eventType', 'motion_detected');

        // Menangani file snapshot jika dikirim secara Multipart/Form-Data
        $snapshotPath = null;
        if ($request->hasFile('snapshot')) {
            $path = $request->file('snapshot')->store('nvr_snapshots', 'public');
            $snapshotPath = "/storage/" . $path;
        }

        // 3. Simpan ke tabel nvr_events
        $nvrEvent = NvrEvent::create([
            'camera_id' => $cameraId,
            'camera_name' => $cameraName,
            'event_type' => $eventType,
            'detected_at' => now(),
            'snapshot_path' => $snapshotPath,
            'metadata' => [
                'request_params' => $payload,
                'raw_body_preview' => substr($rawContent, 0, 500) // Berguna untuk analisis Payload XML/JSON nanti
            ],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Event ter-record dengan aman',
            'event_id' => $nvrEvent->id
        ], 201);
    }
}
