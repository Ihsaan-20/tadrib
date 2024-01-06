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
        Schema::create('sets', function (Blueprint $table) {
            $table->id();
            $table->enum('set_type', ['set', 'super_set']);
            $table->json('exercises');
            $table->integer('no_of_time');
            $table->integer('intra_set_rest');
            $table->integer('inter_set_rest');
            $table->string('estimated_duration');
            $table->foreignId('workout_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sets');
    }
};
