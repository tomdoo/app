<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            $table->string('name', 100);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('timezone');
            $table->text('address')->nullable();
            $table->string('postcode', 10)->nullable();
            $table->string('city', 50)->nullable();
            $table->integer('max_participants')->nullable();
            $table->text('description')->nullable();
            $table->float('price')->nullable();
            $table->string('recurrent_hash', 100)->nullable();

            $table->integer('state_id')->unsigned()->nullable();
            $table->foreign('state_id')
                ->references('id')
                ->on('states');

            $table->integer('country_id')->unsigned()->nullable();
            $table->foreign('country_id')
                ->references('id')
                ->on('countries');

            $table->integer('club_photo_id')->unsigned()->nullable();
            $table->foreign('club_photo_id')
                ->references('id')
                ->on('club_photos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
