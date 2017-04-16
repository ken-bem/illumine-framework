<?php namespace WppSkeleton\Http\Requests;
use Closure;
class UserRequest extends Request
{

    public static function handle($request, Closure $next)
    {
        return $next($request);
    }

}
