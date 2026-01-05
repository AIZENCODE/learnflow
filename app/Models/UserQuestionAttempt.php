<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserQuestionAttempt extends Model
{
    protected $table = 'user_question_attempt';

    protected $fillable = [
        'user_id',
        'lesson_item_id',
        'question_id',
        'selected_option_id',
        'text_answer',
        'selected_option_ids',
        'is_correct',
        'points_earned',
        'status',
        'feedback',
        'score',
    ];

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
            'points_earned' => 'integer',
            'score' => 'integer',
            'selected_option_ids' => 'array',
        ];
    }

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lessonItem(): BelongsTo
    {
        return $this->belongsTo(LessonItem::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedOption(): BelongsTo
    {
        return $this->belongsTo(QuestionOption::class, 'selected_option_id');
    }
}

