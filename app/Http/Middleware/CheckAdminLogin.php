<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect(route('admin.login'))->withErrors(['error' => '请登录']);
        }
        return $next($request);
    }
}
