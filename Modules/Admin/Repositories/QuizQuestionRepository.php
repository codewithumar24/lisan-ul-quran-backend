<?php

namespace Modules\Admin\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Contracts\Repositories\QuizQuestionRepositoryContract;
use Modules\Admin\Entities\QuizQuestion;

readonly class QuizQuestionRepository implements QuizQuestionRepositoryContract
{
    public function __construct(
        private QuizQuestion $model
    ) {}

    public function create(
        int $quizId,
        string $questionEnglish,
        string $questionUrdu,
        string $questionType,
        array $options,
        array $correctAnswers,
        int $displayOrder,
        ?string $explanationEnglish = null,
        ?string $explanationUrdu = null,
        ?string $audioFile = null,
        ?string $imageFile = null,
        int $points = 1,
        int $difficultyLevel = 1
    ): QuizQuestion {
        return $this->model->newQuery()->create([
            'quiz_id' => $quizId,
            'question_english' => $questionEnglish,
            'question_urdu' => $questionUrdu,
            'question_type' => $questionType,
            'options' => $options,
            'correct_answers' => $correctAnswers,
            'display_order' => $displayOrder,
            'explanation_english' => $explanationEnglish,
            'explanation_urdu' => $explanationUrdu,
            'audio_file' => $audioFile,
            'image_file' => $imageFile,
            'points' => $points,
            'difficulty_level' => $difficultyLevel,
        ]);
    }

    public function update(
        QuizQuestion $quizQuestion,
        ?string $questionEnglish = null,
        ?string $questionUrdu = null,
        ?string $questionType = null,
        ?array $options = null,
        ?array $correctAnswers = null,
        ?int $displayOrder = null,
        ?string $explanationEnglish = null,
        ?string $explanationUrdu = null,
        ?string $audioFile = null,
        ?string $imageFile = null,
        ?int $points = null,
        ?int $difficultyLevel = null
    ): QuizQuestion {
        if (!is_null($questionEnglish) && $quizQuestion->question_english !== $questionEnglish) {
            $quizQuestion->question_english = $questionEnglish;
        }
        if (!is_null($questionUrdu) && $quizQuestion->question_urdu !== $questionUrdu) {
            $quizQuestion->question_urdu = $questionUrdu;
        }
        if (!is_null($questionType) && $quizQuestion->question_type !== $questionType) {
            $quizQuestion->question_type = $questionType;
        }
        if (!is_null($options)) {
            $quizQuestion->options = $options;
        }
        if (!is_null($correctAnswers)) {
            $quizQuestion->correct_answers = $correctAnswers;
        }
        if (!is_null($displayOrder) && $quizQuestion->display_order !== $displayOrder) {
            $quizQuestion->display_order = $displayOrder;
        }
        if (!is_null($explanationEnglish)) {
            $quizQuestion->explanation_english = $explanationEnglish;
        }
        if (!is_null($explanationUrdu)) {
            $quizQuestion->explanation_urdu = $explanationUrdu;
        }
        if (!is_null($audioFile)) {
            $quizQuestion->audio_file = $audioFile;
        }
        if (!is_null($imageFile)) {
            $quizQuestion->image_file = $imageFile;
        }
        if (!is_null($points) && $quizQuestion->points !== $points) {
            $quizQuestion->points = $points;
        }
        if (!is_null($difficultyLevel) && $quizQuestion->difficulty_level !== $difficultyLevel) {
            $quizQuestion->difficulty_level = $difficultyLevel;
        }

        $quizQuestion->save();
        return $quizQuestion;
    }

    public function delete(QuizQuestion $quizQuestion): bool
    {
        return $quizQuestion->delete();
    }

    public function findById(int $id): ?QuizQuestion
    {
        return $this->model->newQuery()->with('quiz')->find($id);
    }

    public function findByUuid(string $uuid): ?QuizQuestion
    {
        return $this->model->newQuery()->with('quiz')->where('uuid', $uuid)->first();
    }

    public function getByQuiz(int $quizId): Collection
    {
        return $this->model->newQuery()
            ->where('quiz_id', $quizId)
            ->orderBy('display_order')
            ->get();
    }

    public function updateDisplayOrder(int $quizId, array $orderData): bool
    {
        foreach ($orderData as $item) {
            $this->model->newQuery()
                ->where('quiz_id', $quizId)
                ->where('id', $item['id'])
                ->update(['display_order' => $item['display_order']]);
        }
        return true;
    }

    public function getNextDisplayOrder(int $quizId): int
    {
        $max = $this->model->newQuery()
            ->where('quiz_id', $quizId)
            ->max('display_order');

        return $max ? $max + 1 : 1;
    }

    public function existsInQuiz(int $quizId, string $questionEnglish, ?int $excludeId = null): bool
    {
        $query = $this->model->newQuery()
            ->where('quiz_id', $quizId)
            ->where('question_english', $questionEnglish);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
