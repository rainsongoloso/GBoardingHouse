<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('room_no',25);
            $table->enum('status',['Available','Unavailable']);
            $table->string('type',10);
            $table->string('description',50);
            $table->integer('current_capacity')->default(0);
            $table->integer('max_capacity');
            $table->decimal('rate',16,2);
            $table->string('room_image')->default('default.jpg');
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
        Schema::dropIfExists('rooms');
    }
}
