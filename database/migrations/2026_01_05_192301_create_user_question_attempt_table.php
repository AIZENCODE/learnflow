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
        Schema::create('user_question_attempt', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->comment('Usuario');
            $table->foreignId('lesson_item_id')->constrained('lesson_items')->comment('Item de lección');
            $table->foreignId('question_id')->constrained('questions')->comment('Pregunta');

            // Para preguntas de opción múltiple/verdadero-falso
            $table->foreignId('selected_option_id')
                ->nullable()
                ->constrained('question_options')
                ->comment('Opción seleccionada');

            // Para respuestas de texto
            $table->text('text_answer')->nullable()->comment('Respuesta de texto del usuario');

            // Para múltiples respuestas (guardar como JSON)
            $table->json('selected_option_ids')->nullable()
                ->comment('IDs de opciones seleccionadas (para multiple_answer)');

            // Resultado
            $table->boolean('is_correct')->default(false)->comment('¿Respondió correctamente?');
            $table->integer('points_earned')->default(0)->comment('Puntos obtenidos');

            // Para ensayos/tareas que requieren revisión
            $table->enum('status', ['submitted', 'graded', 'pending_review'])
                ->default('submitted')
                ->comment('Estado de la respuesta');

            $table->text('feedback')->nullable()->comment('Retroalimentación del instructor');
            $table->integer('score')->nullable()->comment('Puntuación asignada');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_question_attempt');
    }
};
