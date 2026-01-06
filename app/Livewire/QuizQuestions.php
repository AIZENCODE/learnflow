<?php

namespace App\Livewire;

use App\Models\LessonItem;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QuizQuestions extends Component
{
    public $lessonItemId;
    public $showQuestionModal = false;
    public $editingQuestion = null;
    
    // Formulario de pregunta
    public $questionText = '';
    public $questionType = 'multiple_choice';
    
    public function updatedQuestionType()
    {
        // Limpiar opciones si el nuevo tipo no las requiere
        $optionsTypes = ['multiple_choice', 'multiple_answer', 'true_false', 'matching'];
        if (!in_array($this->questionType, $optionsTypes)) {
            $this->options = [];
        }
    }
    public $explanation = '';
    public $points = 1;
    public $timeLimit = null;
    public $correctTextAnswer = '';
    
    // Opciones de la pregunta
    public $options = [];
    public $newOptionText = '';
    public $newOptionIsCorrect = false;
    public $newOptionOrder = 0;

    public function mount($lessonItemId)
    {
        $this->lessonItemId = is_object($lessonItemId) ? $lessonItemId->id : $lessonItemId;
    }

    public function getLessonItemProperty()
    {
        return LessonItem::with('questions.questionOptions')->findOrFail($this->lessonItemId);
    }

    public function openQuestionModal($questionId = null)
    {
        $this->editingQuestion = $questionId;
        if ($questionId) {
            $question = Question::with('questionOptions')->findOrFail($questionId);
            $this->questionText = $question->question_text;
            $this->questionType = $question->question_type;
            $this->explanation = $question->explanation ?? '';
            $this->points = $question->points;
            $this->timeLimit = $question->time_limit;
            $this->correctTextAnswer = $question->correct_text_answer ?? '';
            $this->options = $question->questionOptions->map(function($option) {
                return [
                    'id' => $option->id,
                    'text' => $option->option_text,
                    'is_correct' => $option->is_correct,
                    'order' => $option->order,
                ];
            })->toArray();
        } else {
            $this->resetQuestionForm();
        }
        $this->showQuestionModal = true;
    }

    public function closeQuestionModal()
    {
        $this->showQuestionModal = false;
        $this->editingQuestion = null;
        $this->resetQuestionForm();
    }

    public function addOption()
    {
        if (empty($this->newOptionText)) {
            return;
        }

        $this->options[] = [
            'id' => null,
            'text' => $this->newOptionText,
            'is_correct' => $this->newOptionIsCorrect,
            'order' => count($this->options),
        ];

        $this->newOptionText = '';
        $this->newOptionIsCorrect = false;
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
        // Reordenar
        foreach ($this->options as $key => $option) {
            $this->options[$key]['order'] = $key;
        }
    }

    public function toggleOptionCorrect($index)
    {
        // Para multiple_choice y true_false, solo una opción puede ser correcta
        if (in_array($this->questionType, ['multiple_choice', 'true_false'])) {
            foreach ($this->options as $key => $option) {
                $this->options[$key]['is_correct'] = ($key === $index);
            }
        } else {
            // Para multiple_answer, se pueden marcar múltiples
            $this->options[$index]['is_correct'] = !$this->options[$index]['is_correct'];
        }
    }

    public function saveQuestion()
    {
        $validated = $this->validate([
            'questionText' => 'required|string',
            'questionType' => 'required|in:multiple_choice,multiple_answer,true_false,short_answer,essay,matching',
            'explanation' => 'nullable|string',
            'points' => 'required|integer|min:1',
            'timeLimit' => 'nullable|integer|min:0',
            'correctTextAnswer' => 'nullable|string',
        ]);

        // Validar opciones según el tipo
        if (in_array($this->questionType, ['multiple_choice', 'multiple_answer', 'true_false', 'matching'])) {
            if (count($this->options) < 2) {
                $this->addError('options', 'Debe agregar al menos 2 opciones');
                return;
            }

            // Para multiple_choice y true_false, debe haber exactamente una opción correcta
            if (in_array($this->questionType, ['multiple_choice', 'true_false'])) {
                $correctCount = collect($this->options)->where('is_correct', true)->count();
                if ($correctCount !== 1) {
                    $this->addError('options', 'Debe haber exactamente una opción correcta');
                    return;
                }
            }

            // Para multiple_answer, debe haber al menos una opción correcta
            if ($this->questionType === 'multiple_answer') {
                $correctCount = collect($this->options)->where('is_correct', true)->count();
                if ($correctCount < 1) {
                    $this->addError('options', 'Debe haber al menos una opción correcta');
                    return;
                }
            }
        }

        $data = [
            'question_text' => $validated['questionText'],
            'question_type' => $validated['questionType'],
            'explanation' => $validated['explanation'],
            'points' => $validated['points'],
            'time_limit' => $validated['timeLimit'],
            'correct_text_answer' => $validated['correctTextAnswer'],
            'lesson_item_id' => $this->lessonItemId,
            'updated_by' => Auth::id(),
        ];

        if ($this->editingQuestion) {
            $question = Question::findOrFail($this->editingQuestion);
            $question->update($data);
            
            // Eliminar opciones existentes
            $question->questionOptions()->delete();
        } else {
            $data['created_by'] = Auth::id();
            $question = Question::create($data);
        }

        // Crear opciones
        if (in_array($this->questionType, ['multiple_choice', 'multiple_answer', 'true_false', 'matching'])) {
            foreach ($this->options as $index => $option) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $option['text'],
                    'is_correct' => $option['is_correct'],
                    'order' => $index,
                ]);
            }
        }

        $this->closeQuestionModal();
        $this->dispatch('question-saved');
    }

    public function deleteQuestion($questionId)
    {
        $question = Question::findOrFail($questionId);
        $question->delete();
        $this->dispatch('question-deleted');
    }

    public function resetQuestionForm()
    {
        $this->questionText = '';
        $this->questionType = 'multiple_choice';
        $this->explanation = '';
        $this->points = 1;
        $this->timeLimit = null;
        $this->correctTextAnswer = '';
        $this->options = [];
        $this->newOptionText = '';
        $this->newOptionIsCorrect = false;
    }

    public function render()
    {
        $lessonItem = $this->lessonItem;
        $questions = Question::where('lesson_item_id', $this->lessonItemId)
            ->with('questionOptions')
            ->orderBy('id')
            ->get();
        
        return view('livewire.quiz-questions', [
            'questions' => $questions,
        ]);
    }
}

