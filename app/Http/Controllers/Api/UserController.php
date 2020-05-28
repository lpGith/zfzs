<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/5/27
 * Time: 16:26
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Renting;
use Exception;
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * 获取用户信息
     * @param Request $request
     * @return mixed
     */
    public function GetUserInfo(Request $request)
    {
        $openid = $request->get('openid');
        return Renting::where('openid', $openid)->first();

    }

    /**
     * 修改用户信息
     * @param Request $request
     * @return array
     */
    public function UserInfo(Request $request)
    {
        $openid = $request->get('openid');
        $data = $request->except('openid');
        try {
            Renting::where('openid', $openid)->update($data);
            return ['status' => 0, 'msg' => '修改成功', 'data' => Renting::where('openid', $openid)->first()];
        } catch (Exception $exception) {
            return ['status' => 1006, 'msg' => '修改失败'];
        }
    }

    /**
     * 文件上传
     * @param Request $request
     * @return array
     */
    public function upfile(Request $request)
    {
        if ($request->hasFile('file')) {
            $ret = $request->file('file')->store($request->get('openid'), 'card');
            $pic = '/uploads/card/' . $ret;
            return ['status' => 0, 'pic' => $pic, 'url' => config('url.domain') . $pic];
        }

        return ['status' => 1005, 'msg' => '无图片上传'];
    }
}
