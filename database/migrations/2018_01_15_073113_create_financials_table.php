<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financials', function (Blueprint $table) {
            $table->increments('id');
            
            $table->enum('status', ['Paid','Unpaid','Overdue']);
            // $table->string('description');
            
            //reservation, rental, amenities
            $table->enum('remarks',['Advance Payment','Deposit','Rent']);
            //Month to be pay
            $table->date('payment_for');
            //bayronon   
            $table->decimal('debit',16,2)->default(0.00);
            //iyang gi bayad
            $table->decimal('credit',16,2)->default(0.00);
            // //iyahang utang
            // $table->decimal('balance',16,2);
            
            $table->integer('occupant_id')->unsigned();
            $table->foreign('occupant_id')->references('id')->on('occupants');

            // $table->decimal('debit',16,2);
            // $table->decimal('debit',16,2);
            // $table->decimal('credit',16,2);

            // $table->decimal('amount_pay',16,2);
            // $table->integer('user_id')->unsigned();
            // $table->foreign('user_id')->references('id')->on('users');

            // $table->integer('debit_id')->unsigned();
            // $table->foreign('debit_id')->references('id')->on('debits');

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
        Schema::dropIfExists('financials');
    }
}
