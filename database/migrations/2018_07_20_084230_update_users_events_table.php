<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_events', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->unsigned()->change();

            $table->integer('anonymous_user_id')->nullable()->unsigned();
            $table->foreign('anonymous_user_id')
                ->references('id')
                ->on('anonymous_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_events', function (Blueprint $table) {
            $table->integer('user_id')->nullable(false)->change();
            $table->dropColumn('anonymous_user_id');
        });
    }
}
