<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Track extends Model
{
    protected $fillable = [
        'name',
        'description',
        'order',
        'xp_points',
        'has_time_limit',
        'start_date',
        'end_date',
        'time_limit_type',
        'image_path',
        'background_path',
        'video_path',
        'icon_path',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'has_time_limit' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
            'xp_points' => 'float',
            'order' => 'integer',
        ];
    }

    // Relaciones
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function sourceRelationships(): HasMany
    {
        return $this->hasMany(TrackRelationship::class, 'source_track_id');
    }

    public function targetRelationships(): HasMany
    {
        return $this->hasMany(TrackRelationship::class, 'target_track_id');
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
