<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Admin\Contracts\Services\TajweedRuleContract;
use Modules\Admin\Http\Requests\TajweedRuleRequest;
use Modules\Admin\Transformers\TajweedRuleTransformer;

class TajweedRuleController extends Controller
{
    public function __construct(
        private readonly TajweedRuleContract $tajweedRuleService
    ) {}

    /**
     * Get all tajweed rules with filters
     */
    public function index(): JsonResponse
    {
        $rules = $this->tajweedRuleService->getAll(
            request()->get('per_page'),
            request()->get('rule_category'),
            request()->get('difficulty_level') ? (int) request()->get('difficulty_level') : null,
            request()->has('is_basic') ? filter_var(request()->get('is_basic'), FILTER_VALIDATE_BOOLEAN) : null,
            request()->get('search')
        );

        return apiResponse()->pagination($rules)->success(TajweedRuleTransformer::collection($rules));
    }

    /**
     * Get all rule categories
     */
    public function getCategories(): JsonResponse
    {
        $categories = $this->tajweedRuleService->getCategories();
        return apiResponse()->success($categories);
    }

    /**
     * Get rules by category
     */
    public function getByCategory(string $category): JsonResponse
    {
        $rules = $this->tajweedRuleService->getByCategory($category);
        return apiResponse()->success(TajweedRuleTransformer::collection($rules));
    }

    /**
     * Create a new tajweed rule
     */
    public function store(TajweedRuleRequest $request): JsonResponse
    {
        try {
            $rule = $this->tajweedRuleService->create($request->getDTO());
            return apiResponse()->success(new TajweedRuleTransformer($rule), 'Tajweed rule created successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    /**
     * Get a specific tajweed rule by UUID
     */
    public function show(string $uuid): JsonResponse
    {
        $rule = $this->tajweedRuleService->findByUuid($uuid);

        if (!$rule) {
            return apiResponse()->error('Tajweed rule not found.', 404);
        }

        return apiResponse()->success(new TajweedRuleTransformer($rule->load('lessons')));
    }

    /**
     * Update a tajweed rule
     */
    public function update(string $uuid, TajweedRuleRequest $request): JsonResponse
    {
        $rule = $this->tajweedRuleService->findByUuid($uuid);

        if (!$rule) {
            return apiResponse()->error('Tajweed rule not found.', 404);
        }

        try {
            $updatedRule = $this->tajweedRuleService->update($rule, $request->getDTO());
            return apiResponse()->success(new TajweedRuleTransformer($updatedRule), 'Tajweed rule updated successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    /**
     * Delete a tajweed rule
     */
    public function destroy(string $uuid): JsonResponse
    {
        $rule = $this->tajweedRuleService->findByUuid($uuid);

        if (!$rule) {
            return apiResponse()->error('Tajweed rule not found.', 404);
        }

        try {
            $this->tajweedRuleService->delete($rule);
            return apiResponse()->success(null, 'Tajweed rule deleted successfully.');
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
            'order.*.id' => ['required', 'integer', 'exists:tajweed_rules,id'],
            'order.*.display_order' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $this->tajweedRuleService->updateDisplayOrder($request->input('order'));
            return apiResponse()->success(null, 'Display order updated successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }
}
