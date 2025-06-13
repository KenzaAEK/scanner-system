<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->id('id_presence');
            $table->string('code_apoge');
            $table->unsignedBigInteger('id_seance');
            $table->boolean('est_present')->default(false);
            $table->boolean('est_retard')->default(false);
            $table->text('commentaire')->nullable();
            $table->dateTime('heure_pointage')->nullable();
            $table->enum('methode_pointage', ['Manuel', 'Scan', 'QR-Code'])->default('Manuel');
            $table->timestamps();

            // Foreign keys
            $table->foreign('code_apoge')->references('code_apoge')->on('etudiants')->onDelete('cascade');
            $table->foreign('id_seance')->references('id_seance')->on('seances')->onDelete('cascade');
            
            // Contrainte unique pour éviter les doublons
            $table->unique(['code_apoge', 'id_seance']);
            
            // Index pour optimiser les requêtes
            $table->index('id_seance');
            $table->index('code_apoge');
        });
    }

    public function down()
    {
        Schema::dropIfExists('presences');
    }
};