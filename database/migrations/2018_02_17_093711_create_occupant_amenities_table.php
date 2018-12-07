<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccupantAmenitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occupant_amenities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('occupant_id')->unsigned();
            $table->foreign('occupant_id')->references('id')->on('occupants');
            $table->integer('amenities_id')->unsigned();
            $table->foreign('amenities_id')->references('id')->on('amenities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('occupant_amenities');
    }
}
