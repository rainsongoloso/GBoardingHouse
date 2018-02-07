<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomCapacitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('room_capacities', function (Blueprint $table) {
        //     $table->increments('id');
            
        //     // $table->unsignedInteger('user_id')->nullable();
        //     // $table->foreign('user_id')->references('id')->on('users');

        //     // $table->unsignedInteger('room_id');
        //     // $table->foreign('room_id')->references('id')->on('rooms');
        //     // $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('room_capacities');
    }
}
