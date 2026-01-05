<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'order',
        'is_published',
        'course_id',
        'xp_points',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'order' => 'integer',
            'xp_points' => 'float',
        ];
    }

    // Relaciones
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function lessonItems(): HasMany
    {
        return $this->hasMany(LessonItem::class);
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
