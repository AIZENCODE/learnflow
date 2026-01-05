<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'show_media_type',
        'icon_path',
        'image_path',
        'video_path',
        'is_external_link',
        'short_description',
        'duration_minutes',
        'price',
        'is_free',
        'is_published',
        'order_in_track',
        'xp_points',
        'track_id',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_external_link' => 'boolean',
            'is_free' => 'boolean',
            'is_published' => 'boolean',
            'price' => 'decimal:2',
            'duration_minutes' => 'integer',
            'xp_points' => 'float',
            'order_in_track' => 'integer',
        ];
    }

    // Relaciones
    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
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
