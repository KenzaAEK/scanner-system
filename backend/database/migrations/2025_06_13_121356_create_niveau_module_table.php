<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('niveau_module', function (Blueprint $table) {
            $table->unsignedBigInteger('id_niveau');
            $table->unsignedBigInteger('id_module');
            $table->decimal('coefficient', 3, 1)->default(1.0);
            $table->tinyInteger('semestre')->nullable();
            $table->timestamps();

            // Clé primaire composée
            $table->primary(['id_niveau', 'id_module']);

            // Foreign keys
            $table->foreign('id_niveau')->references('id_niveau')->on('niveaux')->onDelete('cascade');
            $table->foreign('id_module')->references('id_module')->on('modules')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('niveau_module');
    }
};