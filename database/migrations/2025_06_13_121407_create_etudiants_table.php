<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->string('code_apoge')->primary();
            $table->string('nom');
            $table->string('prenom');
            $table->unsignedBigInteger('id_classe');
            $table->string('email')->unique()->nullable();
            $table->date('date_naissance')->nullable();
            $table->enum('statut', ['Actif', 'Inactif', 'Redoublant'])->default('Actif');
            $table->timestamps();

            // Foreign key
            $table->foreign('id_classe')->references('id_classe')->on('classes')->onDelete('restrict');
            
            // Index pour optimiser les requêtes
            $table->index('id_classe');
        });
    }

    public function down()
    {
        Schema::dropIfExists('etudiants');
    }
};