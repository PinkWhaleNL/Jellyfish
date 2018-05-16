<?php

namespace Pinkwhale\Jellyfish\Middleware;

use Closure;
use Pinkwhale\Jellyfish\Models\Session;

class Auth
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
        if(!session()->has('jelly')){
            return redirect(config('jf.slug').'/login');
        }

        // Validate Session.
        if(!(new Session)->CheckSession()){
            session()->forget('jelly');
            return redirect(config('jf.slug').'/login');
        }

        // Validate.
        return $next($request);
    }
}
