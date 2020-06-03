<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{

    //登录界面
    public function index()
    {
        if (auth()->check()) {
            return redirect(route('admin.index'));
        }
        return view('admin.login.index');
    }


    //登录
    public function login(LoginRequest $request)
    {
        //参数
        $post = $request->except('_token');

        $ret = auth()->attempt($post);

        if ($ret) {
            //判断是否为超级管理员
            if (config('rbac.super') !== $post['username']) {
                $user = auth()->user();
                $role = $user->role;  //pluck(value) ： 返回指定key的值组成的集合  pluck(value, key) : 返回指定value,key的值组成的集合
                $nodeArr = $role->nodes()->pluck('route_name', 'id')->toArray();
                session(['admin.auth' => $nodeArr]);
            } else {
                session(['admin.auth' => true]);
            }

            return redirect(route('admin.index'));
        } else {
            return redirect(route('admin.login'))->withErrors(['error' => '登录失败']);
        }
    }

}
