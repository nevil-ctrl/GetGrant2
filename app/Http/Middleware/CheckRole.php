<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! Auth::check()) {
            abort(403, 'Доступ запрещён');
        }

        $userRole = Auth::user()->role;
        
        // Если передано несколько ролей через запятую (например, 'teacher,admin')
        $allowedRoles = [];
        foreach ($roles as $role) {
            $allowedRoles = array_merge($allowedRoles, explode(',', $role));
        }
        
        if (! in_array($userRole, $allowedRoles)) {
            abort(403, 'Доступ запрещён');
        }

        return $next($request);
    }
}
