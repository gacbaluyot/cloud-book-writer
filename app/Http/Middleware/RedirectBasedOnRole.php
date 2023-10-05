<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // If the user isn't logged in, do nothing special:
        if (!auth()->check()) {
            return $next($request);
        }

        $roleName = strtolower(auth()->user()->role->name); // Assuming a user can have multiple roles and we're considering the first one.

        return match ($roleName) {
            'admin' => redirect('/admin/dashboard'),
            'author' => redirect('/author/dashboard'),
            'collaborator' => redirect('/collaborator/dashboard'),
            default => $next($request),
        };
    }

}
