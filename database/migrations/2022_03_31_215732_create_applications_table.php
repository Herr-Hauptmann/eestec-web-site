<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->string('facebook_profile');
            $table->unsignedBigInteger('faculty_id');
            $table->foreign('faculty_id')->references('id')->on('faculties');
            $table->string('field_of_study');
            $table->integer('year_of_study');
            $table->date('birth_date');
            $table->string('phone_number');
            $table->string('email');
            //team id je many to many
            $table->unsignedBigInteger('reference_id');
            $table->foreign('reference_id')->references('id')->on('references');
            $table->longText('experience');
            $table->longText('expectations');
            $table->longText('contribution');
            $table->text('additional_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
};
