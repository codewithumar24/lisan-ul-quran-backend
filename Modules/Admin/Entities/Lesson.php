<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Modules\Admin\Entities\Lesson
 *
 * @property int $id
 * @property string $uuid
 * @property string $title_english
 * @property string $title_urdu
 * @property string|null $title_arabic
 * @property string $description_english
 * @property string $description_urdu
 * @property string $lesson_type
 * @property int $chapter_number
 * @property int $lesson_number
 * @property array $content
 * @property array $learning_objectives
 * @property array|null $prerequisite_lessons
 * @property int $estimated_minutes
 * @property int $difficulty_level
 * @property string|null $thumbnail_image
 * @property string|null $video_url
 * @property array|null $attachments
 * @property bool $is_published
 * @property string|null $published_at
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Lesson extends Model
{
    use SoftDeletes;

    protected $table = 'lessons';
    protected $guarded = [];

    protected $casts = [
        'content' => 'array',
        'learning_objectives' => 'array',
        'prerequisite_lessons' => 'array',
        'attachments' => 'array',
        'chapter_number' => 'integer',
        'lesson_number' => 'integer',
        'estimated_minutes' => 'integer',
        'difficulty_level' => 'integer',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    /**
     * Get the Arabic letters associated with this lesson
     */
    public function arabicLetters()
    {
        return $this->belongsToMany(ArabicLetter::class, 'lesson_letter')
            ->withTimestamps();
    }

    /**
     * Get the Tajweed rules associated with this lesson
     */
    public function tajweedRules()
    {
        return $this->belongsToMany(TajweedRule::class, 'lesson_tajweed_rule')
            ->withTimestamps();
    }

    /**
     * Get the prerequisite lessons
     */
    public function prerequisites()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_prerequisites',
            'lesson_id', 'prerequisite_lesson_id')
            ->withTimestamps();
    }

    /**
     * Get the lessons that have this as prerequisite
     */
    public function dependentLessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_prerequisites',
            'prerequisite_lesson_id', 'lesson_id')
            ->withTimestamps();
    }

    /**
     * Get the practice exercises for this lesson
     */
    public function practiceExercises()
    {
        return $this->hasMany(PracticeExercise::class);
    }

    /**
     * Get the quizzes for this lesson
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get user progress for this lesson
     */
    public function userProgress()
    {
        return $this->hasMany(UserLessonProgress::class);
    }

    /**
     * Scope to order by chapter and lesson number
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('chapter_number')->orderBy('lesson_number');
    }

    /**
     * Scope to filter by lesson type
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('lesson_type', $type);
    }

    /**
     * Scope to get published lessons only
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to filter by difficulty level
     */
    public function scopeByDifficulty($query, int $level)
    {
        return $query->where('difficulty_level', $level);
    }

    /**
     * Scope to filter by chapter
     */
    public function scopeByChapter($query, int $chapter)
    {
        return $query->where('chapter_number', $chapter);
    }

    /**
     * Get the full lesson identifier (chapter.lesson)
     */
    public function getIdentifierAttribute(): string
    {
        return $this->chapter_number . '.' . str_pad($this->lesson_number, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Get the display title with identifier
     */
    public function getDisplayTitleAttribute(): string
    {
        return "Lesson {$this->identifier}: {$this->title_english}";
    }
}
