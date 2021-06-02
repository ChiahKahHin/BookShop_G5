<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ... $roles)
    {
        $user = Auth::user();
        // dd($user->role, $roles, in_array("1", $roles));
        if ($user->role === 0 && in_array("admin", $roles))
            return $next($request);
        else if ($user->role === 1 && in_array("customer", $roles))
            return $next($request);

        return redirect()->route("home");
    }
}
