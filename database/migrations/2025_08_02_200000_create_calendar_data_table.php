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
        Schema::create('calendar_data', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('date_key'); // Y-m-d format
            $table->string('data_type'); // userShifts, availability, timeOff
            $table->json('data');
            $table->string('meta_etag')->nullable();
            $table->timestamp('meta_last_updated')->nullable();
            $table->timestamp('fetched_at');
            $table->boolean('is_stale')->default(false);
            $table->timestamps();

            // Indexes for efficient querying
            $table->index(['user_id', 'date_key', 'data_type']);
            $table->index(['user_id', 'fetched_at']);
            $table->index(['is_stale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_data');
    }
}; 