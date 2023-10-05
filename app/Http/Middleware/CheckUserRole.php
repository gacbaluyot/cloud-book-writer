<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        // Explode the roles by comma to make an array
        $allowedRoles = explode(',', implode(',', $roles));

        if (!in_array(strtolower($user->role->name), array_map('strtolower', $allowedRoles))) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT ROLES.');
        }

        return $next($request);
    }
}
