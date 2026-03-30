<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Modules\Admin\Entities\QuizQuestion
 *
 * @property int $id
 * @property string $uuid
 * @property int $quiz_id
 * @property string $question_english
 * @property string $question_urdu
 * @property string $question_type
 * @property array $options
 * @property array $correct_answers
 * @property string|null $explanation_english
 * @property string|null $explanation_urdu
 * @property string|null $audio_file
 * @property string|null $image_file
 * @property int $points
 * @property int $difficulty_level
 * @property int $display_order
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class QuizQuestion extends Model
{
    use SoftDeletes;

    protected $table = 'quiz_questions';
    protected $guarded = [];

    protected $casts = [
        'options' => 'array',
        'correct_answers' => 'array',
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

        static::created(function ($model) {
            $model->quiz->updateTotalQuestions();
        });

        static::deleted(function ($model) {
            $model->quiz->updateTotalQuestions();
        });
    }

    /**
     * Get the quiz that owns this question
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Scope to order by display order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    /**
     * Scope to filter by question type
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('question_type', $type);
    }

    /**
     * Scope to filter by difficulty level
     */
    public function scopeByDifficulty($query, int $level)
    {
        return $query->where('difficulty_level', $level);
    }
}
