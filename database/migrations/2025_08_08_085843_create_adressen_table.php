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
        Schema::create('adressen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gebaeude_id')->constrained('gebaeude')->cascadeOnDelete();
            //Foreign Key um Adresse mit Gebäude zu verknüpfen
            $table->string('adresse');
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adressen');
    }
};
