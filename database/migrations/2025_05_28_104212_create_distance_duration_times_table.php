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
        Schema::create('distance_duration_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('start_point')->constrained('stops')->cascadeOnDelete();
            $table->foreignId('end_point')->constrained('stops')->cascadeOnDelete();
            $table->integer('duration_time');
            $table->integer('duration_traffic');
            $table->dateTime('start_time');
            $table->string('distance', );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distance_duration_times');
    }
};
