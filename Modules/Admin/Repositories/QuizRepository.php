<?php

namespace Modules\Admin\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Contracts\Repositories\QuizRepositoryContract;
use Modules\Admin\Entities\Quiz;

readonly class QuizRepository implements QuizRepositoryContract
{
    public function __construct(
        private Quiz $model
    ) {}

    public function create(
        string $titleEnglish,
        string $titleUrdu,
        string $descriptionEnglish,
        string $descriptionUrdu,
        string $quizType,
        ?int $lessonId = null,
        ?int $chapterNumber = null,
        ?int $timeLimitMinutes = null,
        int $passingScorePercentage = 70,
        int $maxAttempts = 3,
        bool $showAnswersAfter = true,
        bool $isPublished = false,
        int $displayOrder = 0
    ): Quiz {
        return $this->model->newQuery()->create([
            'title_english' => $titleEnglish,
            'title_urdu' => $titleUrdu,
            'description_english' => $descriptionEnglish,
            'description_urdu' => $descriptionUrdu,
            'quiz_type' => $quizType,
            'lesson_id' => $lessonId,
            'chapter_number' => $chapterNumber,
            'time_limit_minutes' => $timeLimitMinutes,
            'passing_score_percentage' => $passingScorePercentage,
            'max_attempts' => $maxAttempts,
            'show_answers_after' => $showAnswersAfter,
            'is_published' => $isPublished,
            'display_order' => $displayOrder,
        ]);
    }

    public function update(
        Quiz $quiz,
        ?string $titleEnglish = null,
        ?string $titleUrdu = null,
        ?string $descriptionEnglish = null,
        ?string $descriptionUrdu = null,
        ?string $quizType = null,
        ?int $lessonId = null,
        ?int $chapterNumber = null,
        ?int $timeLimitMinutes = null,
        ?int $passingScorePercentage = null,
        ?int $maxAttempts = null,
        ?bool $showAnswersAfter = null,
        ?bool $isPublished = null,
        ?int $displayOrder = null
    ): Quiz {
        if (!is_null($titleEnglish) && $quiz->title_english !== $titleEnglish) {
            $quiz->title_english = $titleEnglish;
        }
        if (!is_null($titleUrdu) && $quiz->title_urdu !== $titleUrdu) {
            $quiz->title_urdu = $titleUrdu;
        }
        if (!is_null($descriptionEnglish) && $quiz->description_english !== $descriptionEnglish) {
            $quiz->description_english = $descriptionEnglish;
        }
        if (!is_null($descriptionUrdu) && $quiz->description_urdu !== $descriptionUrdu) {
            $quiz->description_urdu = $descriptionUrdu;
        }
        if (!is_null($quizType) && $quiz->quiz_type !== $quizType) {
            $quiz->quiz_type = $quizType;
        }
        if (!is_null($lessonId) && $quiz->lesson_id !== $lessonId) {
            $quiz->lesson_id = $lessonId;
        }
        if (!is_null($chapterNumber) && $quiz->chapter_number !== $chapterNumber) {
            $quiz->chapter_number = $chapterNumber;
        }
        if (!is_null($timeLimitMinutes) && $quiz->time_limit_minutes !== $timeLimitMinutes) {
            $quiz->time_limit_minutes = $timeLimitMinutes;
        }
        if (!is_null($passingScorePercentage) && $quiz->passing_score_percentage !== $passingScorePercentage) {
            $quiz->passing_score_percentage = $passingScorePercentage;
        }
        if (!is_null($maxAttempts) && $quiz->max_attempts !== $maxAttempts) {
            $quiz->max_attempts = $maxAttempts;
        }
        if (!is_null($showAnswersAfter) && $quiz->show_answers_after !== $showAnswersAfter) {
            $quiz->show_answers_after = $showAnswersAfter;
        }
        if (!is_null($isPublished) && $quiz->is_published !== $isPublished) {
            $quiz->is_published = $isPublished;
        }
        if (!is_null($displayOrder) && $quiz->display_order !== $displayOrder) {
            $quiz->display_order = $displayOrder;
        }

        $quiz->save();
        return $quiz;
    }

    public function delete(Quiz $quiz): bool
    {
        return $quiz->delete();
    }

    public function findById(int $id): ?Quiz
    {
        return $this->model->newQuery()
            ->with(['lesson', 'questions'])
            ->find($id);
    }

    public function findByUuid(string $uuid): ?Quiz
    {
        return $this->model->newQuery()
            ->with(['lesson', 'questions'])
            ->where('uuid', $uuid)
            ->first();
    }

    public function getAll(
        ?int $perPage = null,
        ?string $quizType = null,
        ?int $lessonId = null,
        ?int $chapterNumber = null,
        ?bool $isPublished = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection {
        $query = $this->model->newQuery()->with('lesson');

        if ($quizType) {
            $query->where('quiz_type', $quizType);
        }

        if ($lessonId) {
            $query->where('lesson_id', $lessonId);
        }

        if ($chapterNumber) {
            $query->where('chapter_number', $chapterNumber);
        }

        if (!is_null($isPublished)) {
            $query->where('is_published', $isPublished);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title_english', 'like', "%{$search}%")
                    ->orWhere('title_urdu', 'like', "%{$search}%")
                    ->orWhere('description_english', 'like', "%{$search}%")
                    ->orWhere('description_urdu', 'like', "%{$search}%");
            });
        }

        $query->orderBy('display_order');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public function getByLesson(int $lessonId): Collection
    {
        return $this->model->newQuery()
            ->where('lesson_id', $lessonId)
            ->orderBy('display_order')
            ->get();
    }

    public function getByChapter(int $chapterNumber): Collection
    {
        return $this->model->newQuery()
            ->where('chapter_number', $chapterNumber)
            ->orderBy('display_order')
            ->get();
    }

    public function updateDisplayOrder(array $orderData): bool
    {
        foreach ($orderData as $item) {
            $this->model->newQuery()
                ->where('id', $item['id'])
                ->update(['display_order' => $item['display_order']]);
        }
        return true;
    }

    public function getNextDisplayOrder(): int
    {
        $max = $this->model->newQuery()->max('display_order');
        return $max ? $max + 1 : 1;
    }

    public function existsByTitle(string $titleEnglish, ?int $excludeId = null): bool
    {
        $query = $this->model->newQuery()->where('title_english', $titleEnglish);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
