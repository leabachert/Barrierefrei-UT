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
        Schema::create('gebaeude', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('infos')->default(false); // Flag ob vollständige Informationen vorhanden sind
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gebaeude');
    }
};
