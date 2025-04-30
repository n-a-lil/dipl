<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artist_id');
            $table->string('title', 100);
            $table->date('release_date')->nullable();
            $table->string('cover_image', 255)->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('genre_id')->nullable();
            $table->timestamps();
        });

        // Добавляем album_id в таблицу tracks (отдельная миграция)
        Schema::table('tracks', function (Blueprint $table) {
            $table->unsignedBigInteger('album_id')->nullable()->after('artist_id');
        });
    }

    public function down()
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->dropColumn('album_id');
        });
        
        Schema::dropIfExists('albums');
    }
};