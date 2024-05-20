<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Response API
 */
class ResponseApi extends JsonResponse
{
  /**
   *  @method static \App\Http\Controllers\ApiResponse success(int $httpCode, string $message, string $title, mixed $data = [])
   */
  public static function success(int $httpCode, string $message, string $title, mixed $data = []): JsonResponse
  {
    return response()->json([
      'message' => $message,
      'title' => $title,
      'data' => $data
    ], $httpCode);
  }

  /**
   *  @method static \App\Http\Controllers\ApiResponse error(int $httpCode, string $message, string $error)
   */
  public static function error(int $httpCode, string $message, string $error): JsonResponse
  {
    return response()->json([
      'message' => $message,
      'error' => $error,
    ], $httpCode);
  }

  /**
   *  @method static \App\Http\Controllers\ApiResponse formError(int $httpCode, string $message, mixed $formError = [])
   */
  public static function formError(int $httpCode, string $message, mixed $formError = []): JsonResponse
  {
    return response()->json([
      'message' => $message,
      'formError' => $formError
    ], $httpCode);
  }
}
