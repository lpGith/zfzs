<?php

namespace App\Model;


class Fangattr extends Base
{
    //获取所有属性
    public function getList()
    {
        $data = self::get()->toArray();

        return $this->treeLevel($data);
    }

    //图片获取器
    public function getIconAttribute()
    {
        return config('url.domain') . $this->attributes['icon'];
    }
}
