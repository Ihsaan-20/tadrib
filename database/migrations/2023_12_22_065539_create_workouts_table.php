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
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('tags')->nullable();
            $table->text('introductory_video')->nullable();
            $table->text('text_bio')->nullable();
             $table->unsignedBigInteger('coach_id');
            $table->time('estimated_duration_hours')->nullable();
            $table->integer('rest')->nullable();
            $table->json('number_of_exercises')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workouts');
    }
};
