<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackRelationship extends Model
{
    protected $fillable = [
        'source_track_id',
        'target_track_id',
        'relationship_type',
    ];

    // Relaciones
    public function sourceTrack(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'source_track_id');
    }

    public function targetTrack(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'target_track_id');
    }
}

