<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccupantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occupants', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('flag')->default(false);
            $table->timestamps();

            $table->date('end_date')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('room_id')->unsigned();
            $table->foreign('room_id')->references('id')->on('rooms');

            // $table->integer('amenities_id')->unsigned()->nullable();
            // $table->foreign('amenities_id')->references('id')->on('amenities');

            // $table->integer('reservations_id')->unsigned()->nullable();
            // $table->foreign('reservations_id')->references('id')->on('reservat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('occupants');
    }
}
