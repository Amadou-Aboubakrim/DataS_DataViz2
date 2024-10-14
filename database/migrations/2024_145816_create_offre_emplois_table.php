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
        Schema::create('offre_emplois', function (Blueprint $table) {
        $table->id();
        $table->string('titre');
        $table->string('employeur')->nullable();
        $table->string('region')->nullable();
        $table->string('secteur')->nullable();
        $table->string('contrat')->nullable();
        $table->string('annee_experience')->nullable();
        $table->string('niveau_etude')->nullable();
        $table->text('description')->nullable();
        $table->string('mode_travail')->nullable();
        $table->timestamp('date_publication')->nullable();
        $table->timestamp('date_expiration')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offre_emplois');
    }
};
