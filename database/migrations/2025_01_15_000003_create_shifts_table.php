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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('api_id')->unique();
            $table->string('shift_id');
            $table->string('schedule_id');
            $table->string('venue_id');
            $table->string('venue_name');
            $table->string('title');
            $table->string('schedule_title');
            $table->text('description')->nullable();
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->integer('call_time')->nullable();
            $table->string('status')->default('confirmed');
            $table->integer('worker_count')->default(0);
            $table->integer('current_workers')->default(0);
            $table->boolean('can_punch')->default(false);
            $table->boolean('can_bailout')->default(false);
            $table->boolean('is_timeTracker')->default(false);
            $table->boolean('is_reviewer')->default(false);
            $table->text('worker_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('schedule_worker_notes')->nullable();
            $table->text('schedule_admin_notes')->nullable();
            $table->string('requested_by')->nullable();
            $table->datetime('requested_at')->nullable();
            $table->json('workers')->nullable();
            $table->json('venue')->nullable();
            $table->json('shift_request')->nullable();
            $table->json('documents')->nullable();
            $table->json('time_punches')->nullable();
            $table->string('etag')->nullable();
            $table->datetime('fetched_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'start_time']);
            $table->index(['schedule_id']);
            $table->index(['venue_id']);
            $table->index(['etag']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
}; 