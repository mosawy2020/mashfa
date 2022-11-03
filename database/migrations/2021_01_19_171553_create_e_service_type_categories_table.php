<?php
/*
 * File name: 2021_01_19_171553_create_e_service_type_categories_table.php
 * Last modified: 2021.01.22 at 11:37:49
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEServiceTypeCategoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_e_service_type', function (Blueprint $table) {
            $table->integer('e_service_type_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->primary(['e_service_type_id', 'category_id']);
            $table->foreign('e_service_type_id')->references('id')->on('e_service_types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e_service_type_categories');
    }
}
