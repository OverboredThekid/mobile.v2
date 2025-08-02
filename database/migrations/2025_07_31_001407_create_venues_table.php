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
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('api_id')->unique();
            $table->string('team_id');
            $table->string('venue_name');
            $table->string('venue_slug');
            $table->json('venue_type')->nullable();
            $table->json('venue_color')->nullable();
            $table->text('venue_comment')->nullable();
            $table->string('color_value')->nullable();
            $table->integer('schedules_count')->default(0);
            $table->string('etag')->nullable();
            $table->timestamp('fetched_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
