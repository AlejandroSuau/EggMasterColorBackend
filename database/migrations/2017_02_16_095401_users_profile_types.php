<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersProfileTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_profile_types', function (Blueprint $table) {
            $table->string('profile_service_id')->index()->unique();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('profile_type_id')->unsigned();
            $table->foreign('profile_type_id')->references('id')->on('profile_types')->onDelete('cascade');

            $table->primary(['user_id', 'profile_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_profile_types');
    }
}
