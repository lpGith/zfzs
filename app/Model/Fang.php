<?php

namespace App\Model;


class Fang extends Base
{
    //模型关联 获取房东信息
    public function owner(){
        return $this->belongsTo('FangOwner','fang_owner');
    }
}
