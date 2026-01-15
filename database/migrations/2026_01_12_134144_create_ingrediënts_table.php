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
    Schema::create('ingrediënten', function (Blueprint $table) {
        $table->id();
        $table->foreignId('gerecht_id')
              ->constrained('gerechten')
              ->onDelete('cascade');
        $table->string('naam');
        $table->string('hoeveelheid');   // bijv. "200 g", "2 stuks"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingrediënts');
    }
};
