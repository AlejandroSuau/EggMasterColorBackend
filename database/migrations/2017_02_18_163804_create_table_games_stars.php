<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGamesStars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games_stars', function (Blueprint $table) {
            $table->integer('obtained_second');

            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');

            $table->integer('star_id')->unsigned();
            $table->foreign('star_id')->references('id')->on('stars')->onDelete('cascade');

            $table->timestamps();

            $table->primary(['game_id', 'star_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('games_stars');
    }
}
