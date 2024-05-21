<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ResponseApi;
use Closure;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class CustomThrottleMiddleware
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $maxattempts = 60, $delayMinutes = 1): Response
    {
        $key = $request->ip();
        $result = new ResponseApi;

        // if (RateLimiter::tooManyAttempts($key, $perMinute = 5)) {
        //     return 'Too many attempts!';
        // }

        // RateLimiter::increment($key);

        return response()->json([
            'message' => RateLimiter::remaining($key, $perMinute = 2),
        ]);

        // if (RateLimiter::tooManyAttempts($key, $maxattempts)) {
        //     $result->statusCode(HttpResponse::HTTP_TOO_MANY_REQUESTS);
        //     $result->title('Too Many Requests');
        //     $result->error('Too Many Requests');
        //     return $result;
        // }

        // RateLimiter::increment($key, $delayMinutes);

        return $next($request);
    }
}
