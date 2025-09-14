<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user !== null) {
            $role = $user->role;
        } else {
            $role = null;
        }

        if (!in_array($role, ['editor', 'admin'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        return $next($request);
    }
}
