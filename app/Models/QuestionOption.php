<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionOption extends Model
{
    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
        'order',
        'match_key',
        'match_value',
    ];

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
            'order' => 'integer',
        ];
    }

    // Relaciones
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function userQuestionAttempts(): HasMany
    {
        return $this->hasMany(UserQuestionAttempt::class, 'selected_option_id');
    }
}
