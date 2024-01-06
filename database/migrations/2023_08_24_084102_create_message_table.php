<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('program_id')->nullable();
            $table->longText('audio')->nullable();
            $table->foreign('sender_id')
            ->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('reciever_id');
            $table->foreign('reciever_id')
            ->references('id')->on('users')->onDelete('cascade');
            $table->longText('message')->nullable();
            $table->json('media')->nullable();
            $table->enum('status',['Read','UnRead']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message');
    }
};
