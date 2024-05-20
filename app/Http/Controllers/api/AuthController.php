<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseApi;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(): JsonResponse
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required',
            'gender' => 'required',
            'birthday' => 'required',
        ]);

        if ($validator->fails()) {
            return ResponseApi::formError(Response::HTTP_UNPROCESSABLE_ENTITY, 'Validation error',  $validator->errors());
        }
        $user = new User;
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = bcrypt(request()->password);
        $user->phone = request()->phone;
        $user->gender = request()->gender;
        $user->birthday = request()->birthday;
        $user->save();

        return ResponseApi::success(Response::HTTP_CREATED, 'Resgistered', 'User created successfully', $user);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->only('email', 'password'), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return ResponseApi::formError(Response::HTTP_UNPROCESSABLE_ENTITY, 'Validation error',  $validator->errors());
        }
        $credentials = $request->only('email', 'password');
        if (!$token = Auth::attempt($credentials)) {
            return ResponseApi::error(Response::HTTP_UNAUTHORIZED, 'Unauthorized', 'Invalid credentials');
        }

        return ResponseApi::success(Response::HTTP_OK, 'You are logged in', 'Login Successful', [
            'user' => auth()->user(),
            'token' => $token
        ]);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $logout = auth()->logout();

        if ($logout) {
            return ResponseApi::success(Response::HTTP_OK, 'You are logged out', 'Logout Successful');
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return ResponseApi::success(Response::HTTP_OK, 'Token Refreshed', 'Token Refreshed', ['refreshToken' => auth()->refresh()]);
    }
}
