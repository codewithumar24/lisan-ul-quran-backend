<?php

namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        if (!$request->user() || !$request->user()->hasPermission($permission)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You do not have the required permission.'
            ], 403);
        }

        return $next($request);
    }
}
