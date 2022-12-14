<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->integer('km');
            $table->double('motor');
            $table->integer('year');
            $table->enum('change',['manual','automatic']);
            $table->string('fuel');
            $table->integer('end_plate');
            $table->string('color');
            $table->boolean('only_owner');
            $table->boolean('ipva_paid');
            $table->boolean('licensed');
            $table->boolean('active')->default(true);
            $table->string('bodywork');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('brand_id')->references('id')->on('brands');
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
        Schema::dropIfExists('cars');
    }
}
