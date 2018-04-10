<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->nullable();
            $table->integer('expense_id')->nullable();
            $table->string('payment_type');
            $table->date('date_of_payment');
            $table->double('amount');
            $table->string('payment_method');
            $table->string('payment_document');
            $table->string('mpesa_transaction_id');
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
        Schema::drop('payments');
    }
}
