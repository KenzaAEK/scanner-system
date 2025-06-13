<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seances', function (Blueprint $table) {
            $table->id('id_seance');
            $table->unsignedBigInteger('id_module');
            $table->unsignedBigInteger('id_classe');
            $table->date('date_seance');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->string('salle')->nullable();
            $table->string('enseignant')->nullable();
            $table->enum('type_seance', ['Cours', 'TD', 'TP', 'Examen'])->default('Cours');
            $table->enum('statut', ['Programmée', 'En cours', 'Terminée', 'Annulée'])->default('Programmée');
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_module')->references('id_module')->on('modules')->onDelete('cascade');
            $table->foreign('id_classe')->references('id_classe')->on('classes')->onDelete('cascade');
            
            // Index pour optimiser les requêtes
            $table->index('id_module');
            $table->index('date_seance');
        });
    }

    public function down()
    {
        Schema::dropIfExists('seances');
    }
};