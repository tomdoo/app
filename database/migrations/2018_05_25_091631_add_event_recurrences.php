<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventRecurrences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('recurrence', 15)->nullable();
            $table->string('recurrence_hash', 64)->nullable();
            $table->date('recurrence_end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('recurrence');
            $table->dropColumn('recurrence_hash');
            $table->dropColumn('recurrence_end_date');
        });
    }
}
