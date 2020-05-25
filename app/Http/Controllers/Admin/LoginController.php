<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{

    //登录界面
    public function index(Request $request)
    {
        if (auth()->check()) {
            return redirect(route('admin.index'));
        }
        return view('admin.login.login');
    }

}
