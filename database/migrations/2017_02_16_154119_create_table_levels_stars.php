<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLevelsStars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels_stars', function (Blueprint $table) {
            $table->integer('minimum_score');
            
            $table->integer('level_id')->unsigned();
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');

            $table->integer('star_id')->unsigned();
            $table->foreign('star_id')->references('id')->on('stars')->onDelete('cascade'); 

            $table->primary(['level_id', 'star_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('levels_stars');
    }
}
