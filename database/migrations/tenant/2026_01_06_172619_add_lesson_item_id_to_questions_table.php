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
        Schema::table('questions', function (Blueprint $table) {
            $table->foreignId('lesson_item_id')
                ->nullable()
                ->after('time_limit')
                ->constrained('lesson_items')
                ->onDelete('cascade')
                ->comment('Item de lección al que pertenece la pregunta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['lesson_item_id']);
            $table->dropColumn('lesson_item_id');
        });
    }
};
