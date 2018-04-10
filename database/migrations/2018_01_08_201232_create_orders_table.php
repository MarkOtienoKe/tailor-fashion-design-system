<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->integer('material_id');
            $table->integer('clothe_type_id');
            $table->double('amount_to_pay');
            $table->double('amount_paid');
            $table->date('date_received');
            $table->date('date_of_collection');
            $table->text('description');
            $table->integer('added_by');
            $table->integer('modified_by');
            $table->string('ip_address');
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
        Schema::drop('orders');
    }
}
