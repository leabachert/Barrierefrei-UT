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
        Schema::create('infos_aussen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gebaeude_id')->constrained('gebaeude')->cascadeOnDelete();
            //Foreign Key um Adresse mit Gebäude zu verknüpfen
            $table->boolean('barrierefrei')->nullable();
            $table->string('eingang')->nullable();
            $table->boolean('tueroeffner')->nullable();
            $table->string('haltestelle')->nullable();
            $table->boolean('parkplatz')->nullable();
            $table->string('parkplatz_ort')->nullable();
            $table->string('wegbeschaffenheit')->nullable();
            $table->boolean('blindenleitsystem')->nullable();
            $table->boolean('infosaeule')->nullable();
            $table->string('infosaeule_ort')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infos_aussen');
    }
};
