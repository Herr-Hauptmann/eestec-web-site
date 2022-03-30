<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('applications_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->foreign('application_id')->references('id')->on('applications');
            $table->unsignedBigInteger('team_id');
            $table->foreign('team_id')->references('id')->on('teams');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications_teams');
    }
};
