<?php

use App\Http\Controllers\ResponseApi;
use App\Http\Middleware\CustomThrottleMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Routing\Middleware\ThrottleRequests;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                $result = new ResponseApi;
                $result->statusCode(Response::HTTP_UNAUTHORIZED);
                $result->title('Unauthorized');
                $result->message($e->getMessage());
                $result->data(null);
                return $result;
            }
        });

        $exceptions->render(function (ThrottleRequestsException $e, Request $request) {
            if ($request->is('api/*')) {
                $result = new ResponseApi;
                $result->statusCode(Response::HTTP_TOO_MANY_REQUESTS);
                $result->title('Too Many Requests');
                $result->message($e->getMessage());
                $result->data(null);
                return $result;
            }
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                $result = new ResponseApi;
                $result->statusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                $result->title('Internal Server Error');
                $result->message($e->getMessage());
                $result->data(null);
                return $result;
            }
        });
    })->create();
