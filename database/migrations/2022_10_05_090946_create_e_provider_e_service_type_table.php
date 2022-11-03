<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEProviderEServiceTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_provider_e_service_type', function (Blueprint $table) {
            $table->id();
            $table->integer('e_provider_id')->unsigned();
            $table->integer('e_service_type_id')->nullable()->unsigned();
            $table->foreign('e_service_type_id')->references('id')->on('e_service_types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('e_provider_id')->references('id')->on('e_providers')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e_provider_e_services');
    }
}
