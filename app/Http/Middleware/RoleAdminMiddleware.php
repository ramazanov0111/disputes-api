<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleAdminMiddleware
{
    public function handle($request, Closure $next, $role, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            return response('Unauthorized.', 401);
        }

        $roles = is_array($role)
            ? $role
            : explode('|', $role);

        if (! Auth::guard($guard)->user()->checkRole($role)) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
