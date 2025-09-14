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
        Schema::create('infos_innen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gebaeude_id')->constrained('gebaeude')->cascadeOnDelete();
            //Foreign Key um Adresse mit Gebäude zu verknüpfen
            $table->string('aufzug')->nullable();
            $table->string('toilette')->nullable();
            $table->boolean('infosaeule')->nullable();
            $table->string('infosaeule_ort')->nullable();
            $table->boolean('blindenleitsystem')->nullable();
            $table->string('raumzugang')->nullable();
            $table->boolean('sitzplaetze')->nullable();
            $table->string('sitzplaetze_raum')->nullable();
            $table->boolean('induktionsschleife')->nullable();
            $table->string('induktionsschleife_raum')->nullable();
            $table->boolean('ruheraum')->nullable();
            $table->string('ruheraum_raum')->nullable();
            $table->boolean('sanitatsraum')->nullable();
            $table->string('sanitatsraum_raum')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infos_innen');
    }
};
