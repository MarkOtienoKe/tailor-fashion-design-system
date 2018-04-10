<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->integer('designation_id');
            $table->integer('added_by');
            $table->integer('modified_by');
            $table->string('ip_address');
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('id_number')->unique();
            $table->double('salary');
            $table->date('date_of_employment');
            $table->string('status');
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
        Schema::drop('employees');
    }
}
