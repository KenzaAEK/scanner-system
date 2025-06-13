<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id('id_classe');
            $table->string('nom_classe');
            $table->unsignedBigInteger('id_niveau');
            $table->integer('effectif_max')->default(30);
            $table->timestamps();

            // Foreign key
            $table->foreign('id_niveau')->references('id_niveau')->on('niveaux')->onDelete('cascade');
            
            // Contrainte unique composée
            $table->unique(['nom_classe', 'id_niveau']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('classes');
    }
};