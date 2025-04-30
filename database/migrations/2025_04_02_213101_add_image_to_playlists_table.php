<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToPlaylistsTable extends Migration
{
    public function up()
    {
        Schema::table('playlists', function (Blueprint $table) {
            $table->string('image')->nullable()->after('name');
        });
    }

    public function down()
    {
        Schema::table('playlists', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}