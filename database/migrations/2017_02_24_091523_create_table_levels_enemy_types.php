<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLevelsEnemyTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels_enemy_types', function (Blueprint $table) {
            $table->decimal('probability', 5, 2);

            $table->integer('level_id')->unsigned();
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');

            $table->integer('enemy_type_id')->unsigned();
            $table->foreign('enemy_type_id')->references('id')->on('enemy_types')->onDelete('cascade');

            $table->primary(['level_id', 'enemy_type_id']);

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
        Schema::drop('levels_enemy_types');
    }
}
