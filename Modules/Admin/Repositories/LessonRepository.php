<?php

namespace Modules\Admin\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Contracts\Repositories\LessonRepositoryContract;
use Modules\Admin\Entities\Lesson;

readonly class LessonRepository implements LessonRepositoryContract
{
    public function __construct(
        private Lesson $model
    ) {}

    public function create(
        string $titleEnglish,
        string $titleUrdu,
        ?string $titleArabic,
        string $descriptionEnglish,
        string $descriptionUrdu,
        string $lessonType,
        int $chapterNumber,
        int $lessonNumber,
        array $content,
        array $learningObjectives,
        int $estimatedMinutes,
        ?array $prerequisiteLessons = null,
        int $difficultyLevel = 1,
        ?string $thumbnailImage = null,
        ?string $videoUrl = null,
        ?array $attachments = null,
        bool $isPublished = false,
        ?string $publishedAt = null,
        array $arabicLetterIds = [],
        array $tajweedRuleIds = []
    ): Lesson {
        $lesson = $this->model->newQuery()->create([
            'title_english' => $titleEnglish,
            'title_urdu' => $titleUrdu,
            'title_arabic' => $titleArabic,
            'description_english' => $descriptionEnglish,
            'description_urdu' => $descriptionUrdu,
            'lesson_type' => $lessonType,
            'chapter_number' => $chapterNumber,
            'lesson_number' => $lessonNumber,
            'content' => $content,
            'learning_objectives' => $learningObjectives,
            'prerequisite_lessons' => $prerequisiteLessons,
            'estimated_minutes' => $estimatedMinutes,
            'difficulty_level' => $difficultyLevel,
            'thumbnail_image' => $thumbnailImage,
            'video_url' => $videoUrl,
            'attachments' => $attachments,
            'is_published' => $isPublished,
            'published_at' => $publishedAt,
        ]);

        if (!empty($arabicLetterIds)) {
            $lesson->arabicLetters()->sync($arabicLetterIds);
        }

        if (!empty($tajweedRuleIds)) {
            $lesson->tajweedRules()->sync($tajweedRuleIds);
        }

        return $lesson;
    }

    public function update(
        Lesson $lesson,
        ?string $titleEnglish = null,
        ?string $titleUrdu = null,
        ?string $titleArabic = null,
        ?string $descriptionEnglish = null,
        ?string $descriptionUrdu = null,
        ?string $lessonType = null,
        ?int $chapterNumber = null,
        ?int $lessonNumber = null,
        ?array $content = null,
        ?array $learningObjectives = null,
        ?int $estimatedMinutes = null,
        ?array $prerequisiteLessons = null,
        ?int $difficultyLevel = null,
        ?string $thumbnailImage = null,
        ?string $videoUrl = null,
        ?array $attachments = null,
        ?bool $isPublished = null,
        ?string $publishedAt = null,
        ?array $arabicLetterIds = null,
        ?array $tajweedRuleIds = null
    ): Lesson {
        if (!is_null($titleEnglish) && $lesson->title_english !== $titleEnglish) {
            $lesson->title_english = $titleEnglish;
        }
        if (!is_null($titleUrdu) && $lesson->title_urdu !== $titleUrdu) {
            $lesson->title_urdu = $titleUrdu;
        }
        if (!is_null($titleArabic) && $lesson->title_arabic !== $titleArabic) {
            $lesson->title_arabic = $titleArabic;
        }
        if (!is_null($descriptionEnglish) && $lesson->description_english !== $descriptionEnglish) {
            $lesson->description_english = $descriptionEnglish;
        }
        if (!is_null($descriptionUrdu) && $lesson->description_urdu !== $descriptionUrdu) {
            $lesson->description_urdu = $descriptionUrdu;
        }
        if (!is_null($lessonType) && $lesson->lesson_type !== $lessonType) {
            $lesson->lesson_type = $lessonType;
        }
        if (!is_null($chapterNumber) && $lesson->chapter_number !== $chapterNumber) {
            $lesson->chapter_number = $chapterNumber;
        }
        if (!is_null($lessonNumber) && $lesson->lesson_number !== $lessonNumber) {
            $lesson->lesson_number = $lessonNumber;
        }
        if (!is_null($content)) {
            $lesson->content = $content;
        }
        if (!is_null($learningObjectives)) {
            $lesson->learning_objectives = $learningObjectives;
        }
        if (!is_null($estimatedMinutes) && $lesson->estimated_minutes !== $estimatedMinutes) {
            $lesson->estimated_minutes = $estimatedMinutes;
        }
        if (!is_null($prerequisiteLessons)) {
            $lesson->prerequisite_lessons = $prerequisiteLessons;
        }
        if (!is_null($difficultyLevel) && $lesson->difficulty_level !== $difficultyLevel) {
            $lesson->difficulty_level = $difficultyLevel;
        }
        if (!is_null($thumbnailImage)) {
            $lesson->thumbnail_image = $thumbnailImage;
        }
        if (!is_null($videoUrl)) {
            $lesson->video_url = $videoUrl;
        }
        if (!is_null($attachments)) {
            $lesson->attachments = $attachments;
        }
        if (!is_null($isPublished) && $lesson->is_published !== $isPublished) {
            $lesson->is_published = $isPublished;
            if ($isPublished && !$lesson->published_at) {
                $lesson->published_at = now();
            }
        }
        if (!is_null($publishedAt)) {
            $lesson->published_at = $publishedAt;
        }

        $lesson->save();

        if (!is_null($arabicLetterIds)) {
            $lesson->arabicLetters()->sync($arabicLetterIds);
        }

        if (!is_null($tajweedRuleIds)) {
            $lesson->tajweedRules()->sync($tajweedRuleIds);
        }

        return $lesson;
    }

    public function delete(Lesson $lesson): bool
    {
        return $lesson->delete();
    }

    public function findById(int $id): ?Lesson
    {
        return $this->model->newQuery()
            ->with(['arabicLetters', 'tajweedRules', 'prerequisites'])
            ->find($id);
    }

    public function findByUuid(string $uuid): ?Lesson
    {
        return $this->model->newQuery()
            ->with(['arabicLetters', 'tajweedRules', 'prerequisites'])
            ->where('uuid', $uuid)
            ->first();
    }

    public function findByChapterAndLesson(int $chapterNumber, int $lessonNumber): ?Lesson
    {
        return $this->model->newQuery()
            ->where('chapter_number', $chapterNumber)
            ->where('lesson_number', $lessonNumber)
            ->first();
    }

    public function getAll(
        ?int $perPage = null,
        ?string $lessonType = null,
        ?int $chapterNumber = null,
        ?int $difficultyLevel = null,
        ?bool $isPublished = null,
        ?string $search = null,
        array $with = []
    ): LengthAwarePaginator|Collection {
        $query = $this->model->newQuery()->with($with);

        if ($lessonType) {
            $query->where('lesson_type', $lessonType);
        }

        if ($chapterNumber) {
            $query->where('chapter_number', $chapterNumber);
        }

        if (!is_null($difficultyLevel)) {
            $query->where('difficulty_level', $difficultyLevel);
        }

        if (!is_null($isPublished)) {
            $query->where('is_published', $isPublished);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title_english', 'like', "%{$search}%")
                    ->orWhere('title_urdu', 'like', "%{$search}%")
                    ->orWhere('title_arabic', 'like', "%{$search}%")
                    ->orWhere('description_english', 'like', "%{$search}%")
                    ->orWhere('description_urdu', 'like', "%{$search}%");
            });
        }

        $query->orderBy('chapter_number')->orderBy('lesson_number');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public function getByChapter(int $chapterNumber): Collection
    {
        return $this->model->newQuery()
            ->where('chapter_number', $chapterNumber)
            ->orderBy('lesson_number')
            ->get();
    }

    public function getPublished(): Collection
    {
        return $this->model->newQuery()
            ->where('is_published', true)
            ->orderBy('chapter_number')
            ->orderBy('lesson_number')
            ->get();
    }

    public function syncArabicLetters(Lesson $lesson, array $arabicLetterIds): void
    {
        $lesson->arabicLetters()->sync($arabicLetterIds);
    }

    public function syncTajweedRules(Lesson $lesson, array $tajweedRuleIds): void
    {
        $lesson->tajweedRules()->sync($tajweedRuleIds);
    }

    public function existsInChapter(int $chapterNumber, int $lessonNumber, ?int $excludeId = null): bool
    {
        $query = $this->model->newQuery()
            ->where('chapter_number', $chapterNumber)
            ->where('lesson_number', $lessonNumber);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    public function getNextLessonNumber(int $chapterNumber): int
    {
        $max = $this->model->newQuery()
            ->where('chapter_number', $chapterNumber)
            ->max('lesson_number');

        return $max ? $max + 1 : 1;
    }

    public function updateOrder(array $orderData): bool
    {
        foreach ($orderData as $item) {
            $this->model->newQuery()
                ->where('id', $item['id'])
                ->update([
                    'chapter_number' => $item['chapter_number'],
                    'lesson_number' => $item['lesson_number']
                ]);
        }
        return true;
    }
}
