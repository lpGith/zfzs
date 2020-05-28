<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/5/27
 * Time: 16:39
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Fangattr;

class FangAttrController extends Controller
{
    private $_attr = [

        //租房小组
        'fang_group' => 1,
        //租期方式
        'fang_rent_type' => 4,
        //房源朝向
        'fang_direction' => 7,
        //租赁方式
        'fang_rent_class' => 10
    ];

    //房源属性列表
    public function FangAttr()
    {
        $arr = [];
        foreach ($this->_attr as $k => $v) {
            $arr[$k] = Fangattr::where('pid', $v)->get(['id', 'name']);
        }
        return $arr;
    }
}
