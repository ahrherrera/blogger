<?php

namespace App\Http\Middleware;

use App\Http\Constants\UserTypeEnum;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        if(Auth::user()->user_type->id == UserTypeEnum::admin || Auth::user()->user_type->id == UserTypeEnum::supervisor) {
            return $next($request);
        }
        return response('Not allowed', 401);
    }
}
