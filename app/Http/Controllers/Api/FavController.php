<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/5/27
 * Time: 16:45
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Fav;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FavController extends Controller
{
    /**
     * 房屋收藏
     * @param Request $request
     * @return array|JsonResponse
     */
    public function Collect(Request $request)
    {
        try {
            $data = $this->validate($request, [
                'openid' => 'required',
                'fang_id' => 'required'
            ]);
            //查询该用户是否已经收藏过
            $ret = Fav::where('openid', $data['openid'])->where('fang_id', $data['fang_id'])->first();
            if (is_null($ret)) {
                $ret = Fav::create($data);
            } else {
                Fav::where('openid', $data['openid'])->where('fang_id', $data['fang_id'])->update($data);
            }
            return response()->json(['status' => 0, 'msg' => '添加收藏成功', 'data' => $ret], 201);
        } catch (ValidationException $e) {
            return ['status' => 100010, 'msg' => '数据验证不通过'];
        }
    }

    /**
     * 查看用户是否有收藏的房源
     * @param Request $request
     * @return array
     */
    public function show(Request $request)
    {
        $openid = $request->get('openid');
        $fang_id = $request->get('fang_id');

        $ret = Fav::where('fang_id', $fang_id)->where('openid', $openid)->first();
        if (is_null($ret)) {
            return ['status' => 0];
        } else {
            return ['status' => 1];
        }
    }
}
