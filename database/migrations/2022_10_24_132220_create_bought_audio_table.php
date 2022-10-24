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
        Schema::create('bought_audios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audios_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('reference')->nullable();
            $table->string('price')->nullable();
            $table->foreignId('users_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('artist')->nullable();
            $table->timestamps();

            $table->foreign('artist')
                ->references('username')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bought_audio');
    }
};
