<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname',25);
            $table->string('lastname',25);
            $table->string('street_ad',50);
            $table->string('city',25);
            $table->string('province',25);
            $table->date('dob');
            $table->string('email')->unique();
            $table->string('contact_no',12);
            $table->string('username',25)->unique()->nullable;
            $table->string('password')->nullable;
            $table->enum('status',['Active','Inactive']);
            $table->enum('role',['Client','Tenant','Admin']);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
