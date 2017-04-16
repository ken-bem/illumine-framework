<?php namespace WppSkeleton\Http\Middleware;
use Closure;
class WpSession{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function handle($request, Closure $next)
    {

        return $next($request);
    }
    public function terminate($request, $response)
    {
        // Store the session data...
    }
}
