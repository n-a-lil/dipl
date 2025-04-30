<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('playlist_tracks', function (Blueprint $table) {
            $table->id();
            $table->integer('playlist_id');
            $table->integer('track_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('playlist_tracks');
    }
};
