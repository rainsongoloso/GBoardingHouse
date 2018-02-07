<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForiegnKeyToTableOccupancy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('occupants', function (Blueprint $table) {
        //     //
        //     // $table->unsignedInteger('room_capacity_id')->nullable();
        //     // $table->foreign('room_capacity_id')->references('id')->on('room_capacities');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('occupants', function (Blueprint $table) {
        //     //
        // });
    }
}
