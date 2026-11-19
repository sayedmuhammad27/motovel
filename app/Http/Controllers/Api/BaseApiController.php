<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    /**
     * Response JSON sukses terstandarisasi.
     */
    protected function successResponse(mixed $data = null, string $message = 'Operasi berhasil diproses.', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Response JSON gagal / error terstandarisasi.
     */
    protected function errorResponse(string $message = 'Terjadi kesalahan pada permintaan.', mixed $errors = null, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }
}
