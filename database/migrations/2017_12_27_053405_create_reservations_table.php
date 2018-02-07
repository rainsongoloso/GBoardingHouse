<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->date('start_date');
            // $table->boolean('downpay')->default(false);
            $table->enum('status',['Active','Settled','Cancel']);

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('room_id')->unsigned();
            $table->foreign('room_id')->references('id')->on('rooms');

            // $table->integer('amenities_id')->unsigned()->nullable();
            // $table->foreign('amenities_id')->references('id')->on('amenities');

            $table->timestamps();
            // $table->integer('number_of_persons');

            // $table->integer('reservations_id')->unsigned()->nullable();
            // $table->foreign('reservations_id')->references('id')->on('reservations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
