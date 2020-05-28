<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

//用户控制器
class UserController extends BaseController
{
    //用户列表
    public function index()
    {
        $data = User::withTrashed()->orderBy('id', 'desc')->paginate($this->pageSize);
        return view('admin.user.index', compact('data'));
    }

    //添加页面
    public function create()
    {
        return view('admin.user.create');
    }


    //添加用户
    public function store(Request $request)
    {
        //验证
        $this->validate($request, [
            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed',
            //自定义验证规则
            'phone' => 'nullable|phone'
        ]);

        //参数
        $params = $request->except(['_token', 'password_confirmation']);

        $userModel = User::create($params);
        $pwd = $params['password'];
        //发送邮件
        Mail::send('mail.useradd', compact('userModel', 'pwd'), function (Message $message) use ($userModel) {
            $message->to($userModel->email);
            $message->subject('用户添加成功通知邮件');
        });

            return redirect(route('admin.user.index'))->with('success', '添加用户成功');

    }


    //删除用户
    public function del($id)
    {
        $ret = User::find($id)->delete();
        if ($ret) {
            return [
                'status' => 0,
                'msg' => '删除用户成功'
            ];
        }
    }

    //用户编辑页面
    public function edit($id)
    {
        $info = User::find($id);
        return view(route('admin.user.edit'), compact('info'));
    }


    public function update(Request $request, $id)
    {
        $data = User::find($id);
    }

    public function role()
    {

    }

    //destory(主键) 主键删除
    public function delAll(Request $request)
    {
        $ids = $request->get('id');
        $ret = User::destroy($ids);
        if ($ret) {
            return [
                'status' => 0,
                'msg' => '删除成功'
            ];
        }
    }


    //还原软删除的用户
    public function restore($id)
    {
        $ret = User::onlyTrashed()->where('id', $id)->restore();
        if ($ret) {
            return redirect(route('admin.user.index'))->with('success', '用户还原成功');
        }
    }
}
