<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // public function up()
    // {
    //     Schema::create('payments', function (Blueprint $table) {
    //         $table->increments('id');
    //         $table->decimal('balance',16,2);
    //         $table->string('payment_for');
    //         $table->string('remarks');
    //         $table->decimal('pay_amount',16,2);
    //         $table->timestamps();
            
    //         $table->integer('bill_id')->unsigned();
    //         $table->foreign('bill_id')->references('id')->on('bills');
    //     });
    // }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credits');
    }
}
