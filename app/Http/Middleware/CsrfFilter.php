<?php namespace WppSkeleton\Http\Middleware;
use Closure;
class CsrfFilter{

    public function handle($request, Closure $next)
    {
        return $next($request);
    }
    public function terminate($request, $response)
    {
        // Store the session data...
    }
}
