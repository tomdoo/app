<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            $table->string('name', 50);
            $table->text('address')->nullable();
            $table->string('postcode', 10)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('access_code', 10)->nullable();
            $table->text('description')->nullable();
            $table->string('owner_alias', 50)->nullable();
            $table->string('phone', 20)->nullable();

            $table->integer('state_id')->nullable()->unsigned();
            $table->foreign('state_id')
                ->references('id')
                ->on('states');

            $table->integer('country_id')->unsigned()->nullable();
            $table->foreign('country_id')
                ->references('id')
                ->on('countries');

            $table->integer('club_type_id')->unsigned();
            $table->foreign('club_type_id')
                ->references('id')
                ->on('club_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clubs');
    }
}
