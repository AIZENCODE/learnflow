<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'question_text',
        'explanation',
        'question_type',
        'correct_text_answer',
        'points',
        'time_limit',
        'lesson_item_id',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'points' => 'integer',
            'time_limit' => 'integer',
        ];
    }

    // Relaciones
    public function questionOptions(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function userQuestionAttempts(): HasMany
    {
        return $this->hasMany(UserQuestionAttempt::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function lessonItem(): BelongsTo
    {
        return $this->belongsTo(LessonItem::class);
    }
}
