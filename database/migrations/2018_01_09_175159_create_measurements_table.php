<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->string('measurements_person_name');
            $table->date('measurement_date');
            $table->string('sex');
            $table->double('length');
            $table->double('waist');
            $table->double('bottom');
            $table->double('thigh');
            $table->double('round');
            $table->double('fly');
            $table->double('shoulder');
            $table->double('sleeves');
            $table->double('chest');
            $table->double('tummy');
            $table->double('biceps');
            $table->double('round_sleeve');
            $table->double('burst');
            $table->double('hips');
            $table->double('bodies');
            $table->integer('added_by');
            $table->integer('modified_by');
            $table->string('ip_address');
            $table->text('description');
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
        Schema::drop('measurements');
    }
}
