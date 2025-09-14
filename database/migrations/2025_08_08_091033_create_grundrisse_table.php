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
        Schema::create('grundrisse', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gebaeude_id')->constrained('gebaeude')->cascadeOnDelete();
            //Foreign Key um Adresse mit Gebäude zu verknüpfen
            $table->string('grundriss')->nullable(); // Pfad zur Grundrissdatei
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grundrisse');
    }
};
