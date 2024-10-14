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
        Schema::table('offre_emplois', function (Blueprint $table) {
            $table->text('profil')->nullable();
            $table->text('competences')->nullable();
        });
    }
    
    public function down(): void
    {
        Schema::table('offre_emplois', function (Blueprint $table) {
            $table->dropColumn('profil');
            $table->dropColumn('competences');
        });
    }
    
};
