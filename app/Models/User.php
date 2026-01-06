<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relaciones
    public function createdTracks(): HasMany
    {
        return $this->hasMany(Track::class, 'created_by');
    }

    public function updatedTracks(): HasMany
    {
        return $this->hasMany(Track::class, 'updated_by');
    }

    public function createdCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'created_by');
    }

    public function updatedCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'updated_by');
    }

    public function createdLessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'created_by');
    }

    public function updatedLessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'updated_by');
    }

    public function createdLessonItems(): HasMany
    {
        return $this->hasMany(LessonItem::class, 'created_by');
    }

    public function updatedLessonItems(): HasMany
    {
        return $this->hasMany(LessonItem::class, 'updated_by');
    }

    public function createdQuestions(): HasMany
    {
        return $this->hasMany(Question::class, 'created_by');
    }

    public function updatedQuestions(): HasMany
    {
        return $this->hasMany(Question::class, 'updated_by');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function questionAttempts(): HasMany
    {
        return $this->hasMany(UserQuestionAttempt::class);
    }
}
