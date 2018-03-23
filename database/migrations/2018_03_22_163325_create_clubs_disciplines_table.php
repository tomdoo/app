<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubsDisciplinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubs_disciplines', function (Blueprint $table) {
            $table->integer('club_id')->unsigned();
            $table->foreign('club_id')
                ->references('id')
                ->on('clubs');
            $table->integer('discipline_id')->unsigned();
            $table->foreign('discipline_id')
                ->references('id')
                ->on('disciplines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clubs_disciplines');
    }
}
