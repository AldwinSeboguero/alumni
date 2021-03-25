<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->string('student_number')->unique();
            $table->biginteger('batch_type_id')->unsigned();
            $table->foreign('batch_type_id')->references('id')->on('batch_types');
            $table->biginteger('h_batch_year_id')->unsigned()->nullable();
            $table->foreign('h_batch_year_id')->references('id')->on('h_batch_years');
            $table->biginteger('c_batch_year_id')->unsigned()->nullable();
            $table->foreign('c_batch_year_id')->references('id')->on('c_batch_years');
            $table->biginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('user_details');
    }
}
