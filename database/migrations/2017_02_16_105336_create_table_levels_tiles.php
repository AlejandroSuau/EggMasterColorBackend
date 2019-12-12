<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLevelsTiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels_tiles', function (Blueprint $table) {
            $table->boolean('contain_enemy');

            $table->integer('level_id')->unsigned();
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');

            $table->integer('tile_id')->unsigned();
            $table->foreign('tile_id')->references('id')->on('tiles')->onDelete('cascade');

            $table->primary(['level_id', 'tile_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('levels_tiles');
    }
}
