<?php

namespace App\Model;


class Fang extends Base
{
    //模型关联 获取房东信息
    public function owner()
    {
        return $this->belongsTo('FangOwner', 'fang_owner');
    }

    /**
     * 统计房屋出租总数
     * @return array
     */
    public function FangStatusCount()
    {
        //房屋总数
        $total = self::count();

        //未出租
        $weiTotal = self::where('fang_status', 0)->count();

        //已出租
        $czTotal = $total - $weiTotal;

        return [
            'total' => $total,
            'weiTotal' => $weiTotal,
            'czTotal' => $czTotal
        ];
    }
}
