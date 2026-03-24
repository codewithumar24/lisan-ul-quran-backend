<?php

namespace Modules\User\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\User\Contracts\Services\UserServiceContract;
use Modules\User\Transformers\Auth\LoginResponseTransformer;

class GoogleAuthController extends Controller
{
    public function __construct(
        private readonly UserServiceContract $userService
    ) {}

    public function redirect(): JsonResponse
    {
        $url = $this->userService->getGoogleAuthUrl();
        return apiResponse()->success(['url' => $url]);
    }

    public function callback(): JsonResponse
    {
        try {
            $code = request()->get('code');
            $result = $this->userService->handleGoogleCallback($code);
            return apiResponse()->success(new LoginResponseTransformer($result), 'Google login successful.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }
}
