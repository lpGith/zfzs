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

        //访问的权限
        $auths = is_array(session('admin.auth')) ? array_filter(session('admin.auth')) : [];
        $auths = array_merge($auths, config('rbac.allow_route'));

        //当前访问的路由
        $currentRoute = $request->route()->getName();

        //判断权限
        if (auth()->user()->username != config('rbac.super') && !in_array($currentRoute, $auths)) {
            exit('无操作权限');
        }

        //使用request 传到下级去
        $request->auths = $auths;

        return $next($request);
    }
}
