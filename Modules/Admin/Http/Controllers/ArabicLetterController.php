<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Admin\Contracts\Services\ArabicLetterContract;
use Modules\Admin\Http\Requests\ArabicLetterRequest;
use Modules\Admin\Transformers\ArabicLetterTransformer;

class ArabicLetterController extends Controller
{
    public function __construct(
        private readonly ArabicLetterContract $arabicLetterService
    ) {}

    /**
     * Get all Arabic letters with filters
     */
    public function index(): JsonResponse
    {
        $letters = $this->arabicLetterService->getAll(
            request()->get('per_page'),
            request()->get('makhraj_category'),
            request()->has('has_ghunnah') ? filter_var(request()->get('has_ghunnah'), FILTER_VALIDATE_BOOLEAN) : null,
            request()->has('is_qalqalah') ? filter_var(request()->get('is_qalqalah'), FILTER_VALIDATE_BOOLEAN) : null,
            request()->has('is_madd_letter') ? filter_var(request()->get('is_madd_letter'), FILTER_VALIDATE_BOOLEAN) : null,
            request()->get('search')
        );

        return apiResponse()->pagination($letters)->success(ArabicLetterTransformer::collection($letters));
    }

    /**
     * Get makhraj categories for dropdown
     */
    public function getMakhrajCategories(): JsonResponse
    {
        $categories = $this->arabicLetterService->getMakhrajCategories();
        return apiResponse()->success($categories);
    }

    /**
     * Get letters by makhraj category
     */
    public function getByMakhrajCategory(string $category): JsonResponse
    {
        $letters = $this->arabicLetterService->getByMakhrajCategory($category);
        return apiResponse()->success(ArabicLetterTransformer::collection($letters));
    }

    /**
     * Create a new Arabic letter
     */
    public function store(ArabicLetterRequest $request): JsonResponse
    {
        try {
            $letter = $this->arabicLetterService->create($request->getDTO());
            return apiResponse()->success(new ArabicLetterTransformer($letter), 'Arabic letter created successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    /**
     * Get a specific Arabic letter by UUID
     */
    public function show(string $uuid): JsonResponse
    {
        $letter = $this->arabicLetterService->findByUuid($uuid);

        if (!$letter) {
            return apiResponse()->error('Arabic letter not found.', 404);
        }

        return apiResponse()->success(new ArabicLetterTransformer($letter));
    }

    /**
     * Update an Arabic letter
     */
    public function update(string $uuid, ArabicLetterRequest $request): JsonResponse
    {
        $letter = $this->arabicLetterService->findByUuid($uuid);

        if (!$letter) {
            return apiResponse()->error('Arabic letter not found.', 404);
        }

        try {
            $updatedLetter = $this->arabicLetterService->update($letter, $request->getDTO());
            return apiResponse()->success(new ArabicLetterTransformer($updatedLetter), 'Arabic letter updated successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    /**
     * Delete an Arabic letter
     */
    public function destroy(string $uuid): JsonResponse
    {
        $letter = $this->arabicLetterService->findByUuid($uuid);

        if (!$letter) {
            return apiResponse()->error('Arabic letter not found.', 404);
        }

        try {
            $this->arabicLetterService->delete($letter);
            return apiResponse()->success(null, 'Arabic letter deleted successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    /**
     * Update display order (bulk update)
     */
    public function updateDisplayOrder(): JsonResponse
    {
        $request = request();
        $request->validate([
            'order' => ['required', 'array'],
            'order.*.id' => ['required', 'integer', 'exists:arabic_letters,id'],
            'order.*.display_order' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $this->arabicLetterService->updateDisplayOrder($request->input('order'));
            return apiResponse()->success(null, 'Display order updated successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }
}