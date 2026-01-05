<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //  Preguntas
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            $table->text('question_text')->comment('Texto de la pregunta');
            $table->text('explanation')->nullable()->comment('Explicación de la respuesta');

            $table->enum('question_type', [
                'multiple_choice',  // Opción múltiple (una correcta)
                'multiple_answer',  // Múltiples respuestas correctas
                'true_false',       // Verdadero/Falso
                'short_answer',     // Respuesta corta de texto
                'essay',            // Ensayo/respuesta larga
                'matching'          // Emparejamiento
            ])->default('multiple_choice')->comment('Tipo de pregunta');

            // Para respuestas de texto
            $table->text('correct_text_answer')->nullable()
                ->comment('Respuesta correcta (para short_answer)');

            $table->integer('points')->default(1)->comment('Puntos por responder correctamente');
            $table->integer('time_limit')->nullable()->comment('Límite de tiempo en segundos');

            // Auditoría
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->comment('Creador');

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->comment('Actualizador');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
