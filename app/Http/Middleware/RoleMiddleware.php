<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$params): Response
    {
        // default guard
        $guard = 'web';
        $roles = $params;

        foreach ($params as $key => $param) {
            if (str_starts_with($param, 'guard=')) {
                $guard = str_replace('guard=', '', $param);
                unset($roles[$key]);
            }
        }

        if (!auth($guard)->check() || !in_array(auth($guard)->user()->role->name, $roles)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
