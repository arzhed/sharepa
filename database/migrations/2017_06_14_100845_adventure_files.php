<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdventureFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adventures_photos', function($table) {
            $table->increments('id');
            $table->integer('adventure_id');
            $table->integer('file_id');

            $table->foreign('adventure_id')->references('id')->on('adventures')->onDelete('cascade');
        });

        Schema::table('adventures', function($table) {
            $table->integer('cover_photo')->after('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('adventures_photos');

        Schema::table('adventures', function($table) {
            $table->dropColumn('cover_photo');
        });
    }
}
