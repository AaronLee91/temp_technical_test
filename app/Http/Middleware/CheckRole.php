<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $found = false;
        // retrieve multiple roles from parameter
        $roles = explode("|", $role);

        // return error if not found in either 1 of the role.
        foreach ($roles as $single_role) {
            if ($request->user()->hasRole($single_role)) {
                $found = true;
            }
        }
        if (!$found) {
            return response()->json(['error' => 'This action is unauthorized.'], 401);
        } else {
            return $next($request);
        }

    }
}
