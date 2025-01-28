<?php

use Illuminate\Http\JsonResponse;

if (! function_exists('success')) {

    function success($message, $data = [], $statusCode = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}

if (! function_exists('failure')) {
    function failure($message, $statusCode = 400): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => null,
        ], $statusCode);
    }
}

if (! function_exists('validationError')) {
    function validationError($message, $errors = [], $statusCode = 422): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }
}

if (! function_exists('formatPagination')) {
    function formatPagination($message, $entity, $statusCode = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $entity->items(),
            'total' => $entity->total(),
            'last_page' => $entity->lastPage(),
            'current_page' => $entity->currentPage(),
            'next_page_url' => $entity->nextPageUrl(),
        ], $statusCode);
    }
}

if (! function_exists('resourceFormatPagination')) {
    function resourceFormatPagination($message, $data, $entity, $statusCode = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'total' => $entity->total(),
            'last_page' => $entity->lastPage(),
            'current_page' => $entity->currentPage(),
            'next_page_url' => $entity->nextPageUrl(),
        ], $statusCode);
    }
}
