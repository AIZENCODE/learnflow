<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Opciones de las preguntas
    public function up(): void
    {
        Schema::create('question_options', function (Blueprint $table) {
            $table->id();

            $table->foreignId('question_id')
                ->constrained('questions')
                ->onDelete('cascade')
                ->comment('Pregunta a la que pertenece');

            $table->text('option_text')->comment('Texto de la opción');
            $table->boolean('is_correct')->default(false)->comment('¿Es la respuesta correcta?');
            $table->integer('order')->default(0)->comment('Orden de visualización');

            // Para emparejamiento (matching)
            $table->string('match_key')->nullable()->comment('Clave para emparejar');
            $table->string('match_value')->nullable()->comment('Valor para emparejar');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_options');
    }
};
