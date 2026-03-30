<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Modules\Admin\Entities\PracticeExercise
 *
 * @property int $id
 * @property string $uuid
 * @property int $lesson_id
 * @property string $title_english
 * @property string $title_urdu
 * @property string $exercise_type
 * @property string $instructions_english
 * @property string $instructions_urdu
 * @property array $content
 * @property array|null $correct_response
 * @property array|null $options
 * @property string|null $audio_prompt
 * @property string|null $correct_audio
 * @property int $points
 * @property int $difficulty_level
 * @property int $display_order
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class PracticeExercise extends Model
{
    use SoftDeletes;

    protected $table = 'practice_exercises';
    protected $guarded = [];

    protected $casts = [
        'content' => 'array',
        'correct_response' => 'array',
        'options' => 'array',
        'points' => 'integer',
        'difficulty_level' => 'integer',
        'display_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    /**
     * Get the lesson that owns this practice exercise
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get user practice sessions for this exercise
     */
    public function userPracticeSessions()
    {
        return $this->hasMany(UserPracticeSession::class);
    }

    /**
     * Scope to order by display order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    /**
     * Scope to filter by exercise type
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('exercise_type', $type);
    }

    /**
     * Scope to filter by difficulty level
     */
    public function scopeByDifficulty($query, int $level)
    {
        return $query->where('difficulty_level', $level);
    }

    /**
     * Scope to get exercises for a specific lesson
     */
    public function scopeForLesson($query, int $lessonId)
    {
        return $query->where('lesson_id', $lessonId);
    }
}
