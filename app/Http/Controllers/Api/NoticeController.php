<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/5/27
 * Time: 17:08
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Notice;
use App\Model\Renting;
use Illuminate\Http\Request;

class NoticeController extends Controller
{

    /**
     * 看房通知
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $openid = $request->get('openid');

        //根据openid获取用户id
        $renting_id = Renting::where('openid', $openid)->value('id');

        return Notice::where('renting_id', $renting_id)->with('owner')->orderBy('id', 'desc')->get();
    }
}
