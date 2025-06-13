<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id('id_module');
            $table->string('nom_module');
            $table->string('code_module')->unique()->nullable();
            $table->integer('nb_heures_total')->default(0);
            $table->enum('type_module', ['Cours', 'TD', 'TP', 'Projet'])->default('Cours');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('modules');
    }
};