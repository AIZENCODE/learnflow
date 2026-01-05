<?php

namespace Database\Seeders;

use App\Models\LessonItem;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        $quizItems = LessonItem::where('content_type', 'quiz')->get();

        if ($quizItems->isEmpty()) {
            $this->command->warn('No hay items de tipo quiz. Ejecuta LessonItemSeeder primero.');
            return;
        }

        foreach ($quizItems as $index => $item) {
            // Pregunta de opción múltiple
            $question1 = Question::create([
                'question_text' => '¿Cuál es la etiqueta HTML correcta para crear un encabezado de nivel 1?',
                'explanation' => 'La etiqueta <h1> es la correcta para crear encabezados de nivel 1 en HTML.',
                'question_type' => 'multiple_choice',
                'points' => 10,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            // Pregunta de verdadero/falso
            $question2 = Question::create([
                'question_text' => 'JavaScript es un lenguaje de programación del lado del servidor.',
                'explanation' => 'JavaScript es principalmente un lenguaje del lado del cliente, aunque también puede ejecutarse en el servidor con Node.js.',
                'question_type' => 'true_false',
                'points' => 5,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            // Pregunta de respuesta corta
            $question3 = Question::create([
                'question_text' => '¿Qué significa la sigla CSS?',
                'explanation' => 'CSS significa Cascading Style Sheets (Hojas de Estilo en Cascada).',
                'question_type' => 'short_answer',
                'correct_text_answer' => 'Cascading Style Sheets',
                'points' => 8,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            // Pregunta de múltiples respuestas
            $question4 = Question::create([
                'question_text' => 'Selecciona todas las características de Laravel:',
                'explanation' => 'Laravel incluye todas estas características: Eloquent ORM, sistema de rutas, Blade templating y Artisan CLI.',
                'question_type' => 'multiple_answer',
                'points' => 15,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);
        }
    }
}
