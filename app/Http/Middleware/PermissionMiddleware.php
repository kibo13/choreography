<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission)
    {
        if (!auth()->user()->hasPermission($permission)) {
            // session()->flash('warning', 'У вас нет доступа к этой странице');
            abort(404);
        }

        return $next($request);
    }
}
