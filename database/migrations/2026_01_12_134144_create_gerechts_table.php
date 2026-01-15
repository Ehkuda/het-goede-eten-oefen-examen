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
    Schema::create('gerechten', function (Blueprint $table) {     // let op: gerechten (meervoud)
        $table->id();
        $table->string('naam');
        $table->foreignId('categorie_id')
              ->constrained('categorieen')
              ->onDelete('cascade');
        $table->text('bereidingswijze')->nullable();
        $table->integer('bereidingstijd_minuten')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gerechts');
    }
};
