<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('firstname', 30)->nullable();
            $table->string('lastname', 30)->nullable();
            $table->date('birth_date')->nullable();
            $table->integer('sexe')->nullable();
            $table->string('phone', 20)->nullable();
            $table->integer('newsletter')->nullable();
            $table->dateTime('premium')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
