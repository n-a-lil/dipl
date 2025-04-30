<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->unsignedBigInteger('album_id')->nullable()->after('track_id');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ratings', function (Blueprint $table) {
            // Затем удаляем сам столбец
            $table->dropColumn('album_id');
        });
    }
};