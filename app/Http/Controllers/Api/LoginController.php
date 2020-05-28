<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/5/27
 * Time: 15:55
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Renting;
use Exception;
use GuzzleHttp\Client;
use http\Env\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    /**
     * 登录
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $this->validate($request, [
                'username' => 'required',
                'password' => 'required'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['status' => -1, '账号或密码不能为空'], 400);
        }

        $ret = auth()->guard('apiweb')->attemp($request->all());
        if ($ret) {
            //登录成功,生成token
            $userModel = auth()->guard('apiweb')->user();

            //判断登录次数
            if ($userModel->click > env('APINUM')) {
                return response()->json(['status' => 1002, 'msg' => '当天请求次数超上限'], 500);
            }
            $token = $userModel->createToken('api')->accessToken;
            $data = ['expire' => 7200, 'token' => $token];
            return response()->json($data);

        } else {
            return response()->json(['status' => 1001, 'msg' => '账号或密码不正确'], 400);
        }

    }

    /**
     * 小程序登录
     * @param Request $request
     * @return string
     */
    public function wxLogin(Request $request)
    {
        $appid = 'wx56c5d5fa0073778f';
        $secret = '62129b5d7ef477913e43bfbbc7a97367';
        // 小程序传过来的
        $code = $request->get('code');

        // 请求地址
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code';
        $url = sprintf($url, $appid, $secret, $code);

        // 申请请求客户端  verify 不检查证书ssl
        $client = new Client(['timeout' => 5, 'verify' => false]);
        $ret = $client->get($url);
        $json = (string)$ret->getBody();

        $arr = json_decode($json, true);

        //写入数据表
        try {
            Renting::created(['openid' => $arr['openid']]);
        } catch (Exception $exception) {

        }
        return $json;
    }
}
