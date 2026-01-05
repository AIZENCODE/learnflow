<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionOptionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = Question::all();

        if ($questions->isEmpty()) {
            $this->command->warn('No hay preguntas disponibles. Ejecuta QuestionSeeder primero.');
            return;
        }

        foreach ($questions as $question) {
            if ($question->question_type === 'multiple_choice') {
                // Opciones para pregunta de opción múltiple
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => '<h1>',
                    'is_correct' => true,
                    'order' => 1,
                ]);

                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => '<header>',
                    'is_correct' => false,
                    'order' => 2,
                ]);

                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => '<heading>',
                    'is_correct' => false,
                    'order' => 3,
                ]);

                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => '<h>',
                    'is_correct' => false,
                    'order' => 4,
                ]);
            }

            if ($question->question_type === 'true_false') {
                // Opciones para verdadero/falso
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => 'Verdadero',
                    'is_correct' => false,
                    'order' => 1,
                ]);

                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => 'Falso',
                    'is_correct' => true,
                    'order' => 2,
                ]);
            }

            if ($question->question_type === 'multiple_answer') {
                // Opciones para múltiples respuestas
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => 'Eloquent ORM',
                    'is_correct' => true,
                    'order' => 1,
                ]);

                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => 'Sistema de rutas',
                    'is_correct' => true,
                    'order' => 2,
                ]);

                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => 'Blade templating',
                    'is_correct' => true,
                    'order' => 3,
                ]);

                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => 'Artisan CLI',
                    'is_correct' => true,
                    'order' => 4,
                ]);

                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => 'Compilador de TypeScript',
                    'is_correct' => false,
                    'order' => 5,
                ]);
            }
        }
    }
}
