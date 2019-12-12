<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('win');
            $table->integer('score');
            $table->integer('combos_quantity');
            $table->integer('destroyed_enemies');
            $table->integer('second_when_lost')->nullable();

            $table->integer('level_user_id')->unsigned();
            $table->foreign('level_user_id')->references('id')->on('levels_users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('games');
    }
}
