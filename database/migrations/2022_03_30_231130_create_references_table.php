<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('references', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->timestamps();
        });
        Artisan::call('db:seed', [
            '--class' => 'ReferenceSeeder',
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('references');
    }
};
