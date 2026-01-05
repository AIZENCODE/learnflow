<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'track_id',
        'course_id',
        'status',
        'enrolled_at',
        'completed_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'enrolled_at' => 'datetime',
            'completed_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
