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
  public function register()
  {
    $result = new ResponseApi;
    $validator = Validator::make(request()->all(), [
      'name' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required|min:8',
      'phone' => 'required|unique:users',
      'gender' => 'required',
      'birthday' => 'required',
    ]);

    if ($validator->fails()) {
      $result->statusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
      $result->title('Register Failed');
      $result->message('Validation error');
      $result->formError($validator->errors());
      return $result;
    }

    $user = new User;
    $user->name = request()->name;
    $user->email = request()->email;
    $user->password = bcrypt(request()->password);
    $user->phone = request()->phone;
    $user->gender = request()->gender;
    $user->birthday = request()->birthday;
    $user->save();

    $result->statusCode(Response::HTTP_CREATED);
    $result->message('Created');
    $result->title('Register Successful');
    $result->data($user);
    return $result;
  }

  /**
   * Get a JWT via given credentials.
   */
  public function login(Request $request)
  {
    $result = new ResponseApi;
    $credentials = $request->only('email', 'password');
    $validator = Validator::make($credentials, [
      'email' => 'required|email',
      'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
      $result->statusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
      $result->title('Login Failed');
      $result->message('Validation error');
      $result->formError($validator->errors());
      return $result;
    }


    if (!$token = Auth::attempt($credentials)) {
      $result->statusCode(Response::HTTP_UNAUTHORIZED);
      $result->title('Login Failed');
      $result->error('Invalid Credentials');
      return $result;
    }

    $result->statusCode(Response::HTTP_OK);
    $result->title('Login Successful');
    $result->data([
      'user' => auth()->user(),
      'token' => $token
    ]);
    return $result;
  }


  /**
   * Log the user out (Invalidate the token).
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout()
  {
    auth()->logout(true);

    $result = new ResponseApi;
    $result->statusCode(Response::HTTP_OK);
    $result->title('Logout Successful');
    $result->message('You are logged out');
    $result->data([]);
    return $result;
  }

  /**
   * Refresh a token.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function refresh()
  {
    $result = new ResponseApi;
    $result->statusCode(Response::HTTP_OK);
    $result->title('Token Refreshed');
    $result->message('Token Refreshed');
    $result->data(['refreshToken' => auth()->refresh()]);
    return $result;
  }
}
