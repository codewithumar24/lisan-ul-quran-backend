<?php

namespace Modules\Admin\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Contracts\Repositories\PracticeExerciseRepositoryContract;
use Modules\Admin\Entities\PracticeExercise;

readonly class PracticeExerciseRepository implements PracticeExerciseRepositoryContract
{
    public function __construct(
        private PracticeExercise $model
    ) {}

    public function create(
        int $lessonId,
        string $titleEnglish,
        string $titleUrdu,
        string $exerciseType,
        string $instructionsEnglish,
        string $instructionsUrdu,
        array $content,
        int $points = 10,
        int $difficultyLevel = 1,
        ?array $correctResponse = null,
        ?array $options = null,
        ?string $audioPrompt = null,
        ?string $correctAudio = null,
        int $displayOrder = 0
    ): PracticeExercise {
        return $this->model->newQuery()->create([
            'lesson_id' => $lessonId,
            'title_english' => $titleEnglish,
            'title_urdu' => $titleUrdu,
            'exercise_type' => $exerciseType,
            'instructions_english' => $instructionsEnglish,
            'instructions_urdu' => $instructionsUrdu,
            'content' => $content,
            'correct_response' => $correctResponse,
            'options' => $options,
            'audio_prompt' => $audioPrompt,
            'correct_audio' => $correctAudio,
            'points' => $points,
            'difficulty_level' => $difficultyLevel,
            'display_order' => $displayOrder,
        ]);
    }

    public function update(
        PracticeExercise $practiceExercise,
        ?int $lessonId = null,
        ?string $titleEnglish = null,
        ?string $titleUrdu = null,
        ?string $exerciseType = null,
        ?string $instructionsEnglish = null,
        ?string $instructionsUrdu = null,
        ?array $content = null,
        ?int $points = null,
        ?int $difficultyLevel = null,
        ?array $correctResponse = null,
        ?array $options = null,
        ?string $audioPrompt = null,
        ?string $correctAudio = null,
        ?int $displayOrder = null
    ): PracticeExercise {
        if (!is_null($lessonId) && $practiceExercise->lesson_id !== $lessonId) {
            $practiceExercise->lesson_id = $lessonId;
        }
        if (!is_null($titleEnglish) && $practiceExercise->title_english !== $titleEnglish) {
            $practiceExercise->title_english = $titleEnglish;
        }
        if (!is_null($titleUrdu) && $practiceExercise->title_urdu !== $titleUrdu) {
            $practiceExercise->title_urdu = $titleUrdu;
        }
        if (!is_null($exerciseType) && $practiceExercise->exercise_type !== $exerciseType) {
            $practiceExercise->exercise_type = $exerciseType;
        }
        if (!is_null($instructionsEnglish) && $practiceExercise->instructions_english !== $instructionsEnglish) {
            $practiceExercise->instructions_english = $instructionsEnglish;
        }
        if (!is_null($instructionsUrdu) && $practiceExercise->instructions_urdu !== $instructionsUrdu) {
            $practiceExercise->instructions_urdu = $instructionsUrdu;
        }
        if (!is_null($content)) {
            $practiceExercise->content = $content;
        }
        if (!is_null($points) && $practiceExercise->points !== $points) {
            $practiceExercise->points = $points;
        }
        if (!is_null($difficultyLevel) && $practiceExercise->difficulty_level !== $difficultyLevel) {
            $practiceExercise->difficulty_level = $difficultyLevel;
        }
        if (!is_null($correctResponse)) {
            $practiceExercise->correct_response = $correctResponse;
        }
        if (!is_null($options)) {
            $practiceExercise->options = $options;
        }
        if (!is_null($audioPrompt)) {
            $practiceExercise->audio_prompt = $audioPrompt;
        }
        if (!is_null($correctAudio)) {
            $practiceExercise->correct_audio = $correctAudio;
        }
        if (!is_null($displayOrder) && $practiceExercise->display_order !== $displayOrder) {
            $practiceExercise->display_order = $displayOrder;
        }

        $practiceExercise->save();
        return $practiceExercise;
    }

    public function delete(PracticeExercise $practiceExercise): bool
    {
        return $practiceExercise->delete();
    }

    public function findById(int $id): ?PracticeExercise
    {
        return $this->model->newQuery()->with('lesson')->find($id);
    }

    public function findByUuid(string $uuid): ?PracticeExercise
    {
        return $this->model->newQuery()->with('lesson')->where('uuid', $uuid)->first();
    }

    public function getAll(
        ?int $perPage = null,
        ?int $lessonId = null,
        ?string $exerciseType = null,
        ?int $difficultyLevel = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection {
        $query = $this->model->newQuery()->with('lesson');

        if ($lessonId) {
            $query->where('lesson_id', $lessonId);
        }

        if ($exerciseType) {
            $query->where('exercise_type', $exerciseType);
        }

        if (!is_null($difficultyLevel)) {
            $query->where('difficulty_level', $difficultyLevel);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title_english', 'like', "%{$search}%")
                    ->orWhere('title_urdu', 'like', "%{$search}%")
                    ->orWhere('instructions_english', 'like', "%{$search}%")
                    ->orWhere('instructions_urdu', 'like', "%{$search}%");
            });
        }

        $query->orderBy('lesson_id')->orderBy('display_order');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public function getByLesson(int $lessonId): Collection
    {
        return $this->model->newQuery()
            ->where('lesson_id', $lessonId)
            ->orderBy('display_order')
            ->get();
    }

    public function updateDisplayOrder(int $lessonId, array $orderData): bool
    {
        foreach ($orderData as $item) {
            $this->model->newQuery()
                ->where('lesson_id', $lessonId)
                ->where('id', $item['id'])
                ->update(['display_order' => $item['display_order']]);
        }
        return true;
    }

    public function getNextDisplayOrder(int $lessonId): int
    {
        $max = $this->model->newQuery()
            ->where('lesson_id', $lessonId)
            ->max('display_order');

        return $max ? $max + 1 : 1;
    }

    public function existsInLesson(int $lessonId, string $titleEnglish, ?int $excludeId = null): bool
    {
        $query = $this->model->newQuery()
            ->where('lesson_id', $lessonId)
            ->where('title_english', $titleEnglish);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
