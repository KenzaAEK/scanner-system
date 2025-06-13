<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etudiant', function (Blueprint $table) {
            $table->string('code_apoge')->primary(); 
            $table->string('nom');
            $table->string('prenom');
            $table->unsignedBigInteger('niveau_id');

            $table->foreign('niveau_id')->references('niveau_id')->on('niveau')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etudiant');
    }
};