<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientMedicalFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_medical_files', function (Blueprint $table) {
            $table->id();
            $table->string('diseases_suffers_from')->nullable();
            $table->boolean('married')->nullable(); 
            $table->string('age')->nullable();
            $table->string('medications_takes')->nullable();
            $table->string('history_operations')->nullable();
            $table->string('file')->nullable();
            $table->enum('blood_type', ['A+', 'A-','B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->nullOnDelete();
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
        Schema::dropIfExists('patient_medical_files');
    }
}
