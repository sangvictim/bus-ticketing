<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Get the Profile User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        $result = new ResponseApi;
        $result->message('Profile User');
        $result->success(auth()->user());
        return $result;
        // return $x->success('Profile User', auth()->user());
        // return ResponseApi::success('Profile User', auth()->user());
    }

    /**
     * Get the Notifications User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function notifications()
    {
        $result = new ResponseApi;
        $result->message('Notification User');
        $result->success(auth()->user()->notifications);
        return $result;
        // return ResponseApi::success('Notification User', auth()->user()->notifications);
    }
}
