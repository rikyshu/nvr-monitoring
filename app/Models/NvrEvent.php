<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class NvrEvent extends Model
{
    /** @use HasFactory<\Database\Factories\NvrEventFactory> */
    use HasFactory;

    protected $fillable = [
        'camera_id',
        'camera_name',
        'event_type',
        'detected_at',
        'snapshot_path',
        'metadata',
    ];

    protected $casts = [
        'detected_at' => 'datetime',
        'metadata' => 'array',
    ];
}
