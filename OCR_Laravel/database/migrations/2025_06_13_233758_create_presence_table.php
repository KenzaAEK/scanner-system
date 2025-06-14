<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('presence', function (Blueprint $table) {
            $table->id('presence_id');
            $table->string('code_apoge');
            $table->date('date');
            $table->unsignedBigInteger('module_id')->nullable();
            $table->unsignedBigInteger('classe_id');
            $table->integer('nbr_present');
            $table->timestamps();

            $table->foreign('code_apoge')->references('code_apoge')->on('etudiant')->onDelete('cascade');
            $table->foreign('module_id')->references('module_id')->on('module')->onDelete('set null');
            $table->foreign('classe_id')->references('classe_id')->on('classe')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presence');
    }
};
