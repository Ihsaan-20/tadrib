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
        Schema::create('program_workout_exercise_sets', function (Blueprint $table) {
            $table->id();
            $table->string('program_name')->nullable();
            $table->string('program_intro_video')->nullable();
            $table->string('program_text_bio')->nullable();
            $table->string('program_equi_neede')->nullable();
            $table->string('program_training_type')->nullable();
            $table->string('coach_id')->nullable();
            $table->string('program_profile')->nullable();
            $table->string('program_duration')->nullable();
            $table->string('program_level')->nullable();
            $table->string('program_price')->nullable();
            $table->string('workout_name')->nullable();
            $table->string('workout_intro_video')->nullable();
            $table->string('workout_text_bio')->nullable();
            $table->string('workout_training_type')->nullable();
            $table->string('workout_equi_needed')->nullable();
            $table->string('workout_estimated_duration')->nullable();
            $table->string('workout_rest_days')->nullable();
            $table->string('workout_number_of_exercises')->nullable();
            $table->string('set_type')->nullable();
            $table->string('set_exercises')->nullable();
            $table->string('set_number_of_time_set')->nullable();
            $table->string('set_intra_set_rest')->nullable();
            $table->string('set_inter_set_rest')->nullable();
            $table->string('set_duration_set')->nullable();
            $table->string('exercise_text_bio')->nullable();
            $table->string('exercise_number_of_repeat')->nullable();
            $table->string('exercise_input_example')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_workout_exercise_sets');
    }
};
