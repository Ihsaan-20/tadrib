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
        Schema::create('gym_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('progress')->nullable();

            $table->text('introductory_video')->nullable();
            $table->text('external_video')->nullable();
            $table->text('thumbnail')->nullable();
            $table->text('text_bio')->nullable();
            $table->json('training_type')->nullable();
            $table->json('tag_equipment')->nullable();
            $table->unsignedBigInteger('coach_id');
            $table->integer('duration_weeks');
            $table->enum('level', ['Beginner', 'Intermediate', 'Advanced']);
            $table->decimal('price_usd', 10, 2);
            $table->text('forum_chat')->nullable();
            $table->json('number_of_workout')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_programs');
    }
};
