<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFavoritesToPlaylistsTable extends Migration
{
    public function up()
    {
        Schema::table('playlists', function (Blueprint $table) {
            $table->boolean('is_favorites')->default(false)->after('image');
        });
    }

    public function down()
    {
        Schema::table('playlists', function (Blueprint $table) {
            $table->dropColumn('is_favorites');
        });
    }
}