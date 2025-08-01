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
        Schema::create('available_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('api_id')->unique();
            $table->string('shiftRequest_id')->nullable();
            $table->string('shift_id');
            $table->string('schedule_id');
            $table->text('schedule_worker_notes')->nullable();
            $table->text('schedule_admin_notes')->nullable();
            $table->string('venue_id');
            $table->string('venue_name');
            $table->string('title');
            $table->string('schedule_title');
            $table->integer('call_time')->default(0);
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->text('worker_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->json('workers')->nullable();
            $table->json('venue')->nullable();
            $table->string('etag')->nullable();
            $table->timestamp('fetched_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('start_time');
            $table->index('shift_id');
            $table->index('venue_id');
            $table->index('schedule_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_shifts');
    }
};
