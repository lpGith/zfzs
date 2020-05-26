<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/5/26
 * Time: 10:30
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Fang;
use App\Model\Node;

class IndexController extends Controller
{

    public function index()
    {
        //获取用户权限
        $auth = session('admin.auth');

        $menuData = (new Node())->treeData($auth);

        return view('admin.index.index', compact('menuData'));
    }


    public function welcome()
    {
        $data = (new Fang())->FangStatusCount();
        return view('admin.index.welcome',$data);
    }

    // 退出
    public function logout()
    {
        // 用户退出 清空session
        auth()->logout();
        // 跳转 带提示  闪存 session
        return redirect(route('admin.login'))->with('success', '请重新登录');
    }
}
