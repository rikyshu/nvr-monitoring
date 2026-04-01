<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nvr_events', function (Blueprint $table) {
            $table->id();
            $table->string('camera_id')->index();
            $table->string('camera_name');
            $table->string('event_type')->index();
            $table->timestamp('detected_at')->index();
            $table->string('snapshot_path')->nullable();
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nvr_events');
    }
};
