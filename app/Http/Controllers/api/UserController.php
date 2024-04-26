<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function apiResponse($code, $message, $data)
    {
        return response()->json([
            "code" => $code,
            "message" => $message,
            "data" => $data
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return $this->apiResponse(Response::HTTP_OK, 'Profile User', ['user' => auth()->user()]);
    }

    public function notifications()
    {
        return $this->apiResponse(Response::HTTP_OK, 'Notification User', auth()->user()->notifications);
    }
}
