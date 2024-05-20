<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseApi;
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
        $result->setStatusCode(Response::HTTP_OK);
        $result->title('Profile User');
        $result->data(auth()->user());
        return $result;
    }

    /**
     * Get the Notifications User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function notifications()
    {
        return ResponseApi::success(Response::HTTP_OK, 'Notification User', 'Notification User', auth()->user()->notifications);
    }
}
