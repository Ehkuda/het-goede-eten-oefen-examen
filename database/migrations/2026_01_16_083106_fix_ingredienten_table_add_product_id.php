<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ingredienten', function (Blueprint $table) {
            // Verwijder oude kolom als die bestaat
            $table->dropColumn('naam');           // ← oude string-naam weg

            // Voeg de nieuwe relatie-kolom toe
            $table->foreignId('product_id')
                  ->constrained('producten')
                  ->onDelete('cascade')
                  ->after('gerecht_id');
        });
    }

    public function down(): void
    {
        Schema::table('ingredienten', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');

            // Optioneel: oude kolom terugzetten als je rollback wilt
            $table->string('naam')->after('gerecht_id');
        });
    }
};