<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classe', function (Blueprint $table) {
            $table->id('classe_id'); // Clé primaire auto-incrémentée
            $table->string('nom_classe'); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classe');
    }
};