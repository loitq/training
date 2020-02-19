<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Auth;

class CheckUser
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
        // Get role user logged
        $role = Auth::user()->role;
        // Check not user
        if ($role  !== User::ROLE_USER) {
            return redirect()->back(); 
        }

        return $next($request);
    }
}
