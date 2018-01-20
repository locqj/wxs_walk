<?php

namespace App\Http\Middleware;

use Closure;

class JwtAuthModel
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
        config(['jwt.user' => '\App\Model\User']); //用于重定位model
        config(['auth.providers.users.model' => \App\Model\User::class]); //用于重定位model
        return $next($request);
    }
}
