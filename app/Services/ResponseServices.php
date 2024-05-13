<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class ResponseServices {
    /**
     * Response no allowed
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    static function responseNotAllowed(string $message = null): JsonResponse
    {
      return Response::json([
        'statusCode' => 3,
        'message' => $message ?? 'You do not have permissions to perform this action'
      ], 403);
    }

    /**
     * Response not Authorized
     *
     * @return JsonResponse
     */
    static function responseNotAuthorize(): JsonResponse
    {
      return Response::json([
        'statusCode' => 4,
        'message' => 'You are not authorized to perform this action'
      ], 401);
    }


    /**
     * Response failed
     *
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    static function responseFailed(Array $errors): JsonResponse
    {
      return Response::json([
        'statusCode' => 2,
        'message' => 'form error',
        'errors' => $errors
      ], 422);
    }



    /**
     * Response error
     *
     * @return \Illuminate\Http\JsonResponse
     */
    static function responseError(): JsonResponse {
      return Response::json([
        'statusCode' => 1,
        'message' => 'error server'
      ], 500);
    }


    /**
     * Response error
     *
     * @return \Illuminate\Http\JsonResponse
     */
    static function responseErrorToken(): JsonResponse {
      return Response::json([
        'statusCode' => 1,
        'message' => 'token expired or invalid'
      ], 498);
    }

    /**
     * Response success
     *
     * @param string $message
     * @param [type] $data
     * @return JsonResponse
     */
    static function responseSuccess(string $message = null, $data = null): JsonResponse {
      return Response::json([
        'statusCode' => 0,
        'message' => $message ?? 'success',
        'data' => $data
      ], 200);
    }
}