<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Auth;

class CheckAdmin
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
        // Check not admin
        if ($role  !== User::ROLE_ADMIN) {
            return redirect()->back(); 
        }

        return $next($request);
    }
}
