<?php

namespace App\Helpers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class ApiResponse
{
    private $pagination = null;

    public function pagination(LengthAwarePaginator $paginator): self
    {
        $this->pagination = [
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
        ];

        return $this;
    }

    public function success($data = null, string $message = null, int $statusCode = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($this->pagination) {
            $response['pagination'] = $this->pagination;
            $response['data'] = $data;
        } else {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    public function error(string $message, int $statusCode = 400, $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }
}
