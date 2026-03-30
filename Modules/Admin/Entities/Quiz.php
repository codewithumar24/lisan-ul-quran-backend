<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Modules\Admin\Entities\Quiz
 *
 * @property int $id
 * @property string $uuid
 * @property string $title_english
 * @property string $title_urdu
 * @property string $description_english
 * @property string $description_urdu
 * @property string $quiz_type
 * @property int|null $lesson_id
 * @property int|null $chapter_number
 * @property int|null $time_limit_minutes
 * @property int $passing_score_percentage
 * @property int $total_questions
 * @property int $max_attempts
 * @property bool $show_answers_after
 * @property bool $is_published
 * @property int $display_order
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Quiz extends Model
{
    use SoftDeletes;

    protected $table = 'quizzes';
    protected $guarded = [];

    protected $casts = [
        'passing_score_percentage' => 'integer',
        'total_questions' => 'integer',
        'max_attempts' => 'integer',
        'show_answers_after' => 'boolean',
        'is_published' => 'boolean',
        'display_order' => 'integer',
        'chapter_number' => 'integer',
        'time_limit_minutes' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    /**
     * Get the lesson that owns this quiz
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get the questions for this quiz
     */
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('display_order');
    }

    /**
     * Get user attempts for this quiz
     */
    public function userAttempts()
    {
        return $this->hasMany(UserQuizAttempt::class);
    }

    /**
     * Scope to order by display order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    /**
     * Scope to filter by quiz type
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('quiz_type', $type);
    }

    /**
     * Scope to get published quizzes
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to get quizzes for a lesson
     */
    public function scopeForLesson($query, int $lessonId)
    {
        return $query->where('lesson_id', $lessonId);
    }

    /**
     * Scope to get quizzes for a chapter
     */
    public function scopeForChapter($query, int $chapterNumber)
    {
        return $query->where('chapter_number', $chapterNumber);
    }

    /**
     * Update total questions count
     */
    public function updateTotalQuestions(): void
    {
        $this->total_questions = $this->questions()->count();
        $this->save();
    }
}
