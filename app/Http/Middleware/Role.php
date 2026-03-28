<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // redirect user to 403 if user role does not match
        if (Auth::guard('web')->user()->role !== UserRole::from($role)) {
            return abort(403);
        }

        return $next($request);
    }
}
