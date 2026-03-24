<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Admin\Contracts\Services\MakhrajCategoryContract;
use Modules\Admin\Http\Requests\MakhrajCategoryRequest;
use Modules\Admin\Transformers\MakhrajCategoryTransformer;

class MakhrajCategoryController extends Controller
{
    public function __construct(
        private readonly MakhrajCategoryContract $makhrajCategoryService
    ) {}

    /**
     * Get all makhraj categories
     */
    public function index(): JsonResponse
    {
        $categories = $this->makhrajCategoryService->getAll(
            request()->get('per_page'),
            request()->get('search')
        );

        return apiResponse()->pagination($categories)->success(MakhrajCategoryTransformer::collection($categories));
    }

    /**
     * Create a new makhraj category
     */
    public function store(MakhrajCategoryRequest $request): JsonResponse
    {
        try {
            $category = $this->makhrajCategoryService->create($request->getDTO());
            return apiResponse()->success(new MakhrajCategoryTransformer($category), 'Makhraj category created successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    /**
     * Get a specific makhraj category by UUID
     */
    public function show(string $uuid): JsonResponse
    {
        $category = $this->makhrajCategoryService->findByUuid($uuid);

        if (!$category) {
            return apiResponse()->error('Makhraj category not found.', 404);
        }

        return apiResponse()->success(new MakhrajCategoryTransformer($category->load('arabicLetters')));
    }

    /**
     * Update a makhraj category
     */
    public function update(string $uuid, MakhrajCategoryRequest $request): JsonResponse
    {
        $category = $this->makhrajCategoryService->findByUuid($uuid);

        if (!$category) {
            return apiResponse()->error('Makhraj category not found.', 404);
        }

        try {
            $updatedCategory = $this->makhrajCategoryService->update($category, $request->getDTO());
            return apiResponse()->success(new MakhrajCategoryTransformer($updatedCategory), 'Makhraj category updated successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    /**
     * Delete a makhraj category
     */
    public function destroy(string $uuid): JsonResponse
    {
        $category = $this->makhrajCategoryService->findByUuid($uuid);

        if (!$category) {
            return apiResponse()->error('Makhraj category not found.', 404);
        }

        try {
            $this->makhrajCategoryService->delete($category);
            return apiResponse()->success(null, 'Makhraj category deleted successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    /**
     * Update display order
     */
    public function updateDisplayOrder(): JsonResponse
    {
        $request = request();
        $request->validate([
            'order' => ['required', 'array'],
            'order.*.id' => ['required', 'integer', 'exists:makharij_categories,id'],
            'order.*.display_order' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $this->makhrajCategoryService->updateDisplayOrder($request->input('order'));
            return apiResponse()->success(null, 'Display order updated successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }
}
