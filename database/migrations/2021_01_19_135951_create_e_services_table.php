<?php
/*
 * File name: 2021_01_19_135951_create_e_services_table.php
 * Last modified: 2021.11.15 at 12:44:22
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEServicesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_services', function (Blueprint $table) {
            $table->increments('id');
//            $table->longText('name')->nullable();
            $table->double('price', 10, 2)->default(0);
            $table->double('discount_price', 10, 2)->nullable()->default(0);
            $table->enum('price_unit', ['hourly', 'fixed']);
            $table->longText('quantity_unit')->nullable()->default(null);
            $table->string('duration', 16)->nullable();
//            $table->longText('description')->nullable();
            $table->boolean('featured')->nullable()->default(0);
            $table->boolean('enable_booking')->nullable()->default(1);
            $table->boolean('available')->nullable()->default(1);
            $table->integer('e_provider_id')->unsigned();
            $table->integer('e_service_type_id')->unsigned();
            $table->foreign('e_provider_id')->references('id')->on('e_providers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('e_service_type_id')->references('id')->on('e_service_types')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::drop('e_services');
    }
}
