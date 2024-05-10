<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseApi;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Get the Profile User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return ResponseApi::success('Profile User', auth()->user());
    }

    /**
     * Get the Notifications User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function notifications(): JsonResponse
    {
        return ResponseApi::success('Notification User', auth()->user()->notifications);
    }
}
