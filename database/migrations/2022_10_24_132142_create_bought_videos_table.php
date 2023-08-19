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
        Schema::create('bought_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained();
            $table->string('username');
            $table->string('artist');
            $table->string('price');
            $table->timestamps();

            $table->foreign('username')
                ->references('username')
                ->on('users');

            $table->foreign('artist')
                ->references('username')
                ->on('users');

            $table->unique(['video_id', 'username']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bought_videos');
    }
};
