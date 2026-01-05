<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LessonItem extends Model
{
    protected $fillable = [
        'title',
        'description',
        'order',
        'content_type',
        'completion_type',
        'content',
        'video_url',
        'video_duration',
        'external_url',
        'file_path',
        'is_preview',
        'is_published',
        'requires_completion',
        'xp_points',
        'lesson_id',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_preview' => 'boolean',
            'is_published' => 'boolean',
            'requires_completion' => 'boolean',
            'order' => 'integer',
            'video_duration' => 'integer',
            'xp_points' => 'float',
        ];
    }

    // Relaciones
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
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
}
