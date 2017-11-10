<?php

namespace Pinkwhale\Jellyfish\Middleware;

use Closure;
use JellyAuth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // Check if session exists.
        if(!JellyAuth::IsAdmin()){
            return redirect()->route('jelly-dashboard');
        }

        // Validate.
        return $next($request);
    }
}
