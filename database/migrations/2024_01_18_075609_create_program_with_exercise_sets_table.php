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
        Schema::create('program_with_exercise_sets', function (Blueprint $table) {
            $table->id();
            $table->json('program')->nullable();
            // $table->string('program_name')->nullable();
            // $table->string('program_intro_video')->nullable();
            // $table->string('program_text_bio')->nullable();
            // $table->string('program_equi_neede')->nullable();
            // $table->string('program_training_type')->nullable();
            // $table->string('coach_id')->nullable();
            // $table->string('program_profile')->nullable();
            // $table->string('program_duration')->nullable();
            // $table->string('program_level')->nullable();
            // $table->string('program_price')->nullable();
            // $table->json('workouts')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_with_exercise_sets');
    }
};
