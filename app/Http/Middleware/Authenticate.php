<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UserType;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
        if(Auth::user()){
            Auth::user()->user_type = UserType::find(auth()->user()->user_type);
            Auth::user()->user_boss = User::find(auth()->user()->boss_id);
        }
        return parent::handle($request, $next, $guards);
    }

}
