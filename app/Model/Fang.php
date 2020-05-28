<?php

namespace App\Model;


class Fang extends Base
{

    //追加字段
    protected $appends = ['pic', 'shi_ting'];

    //模型关联 获取房东信息
    public function owner()
    {
        return $this->belongsTo('FangOwner', 'fang_owner');
    }

    //读取器

    /**
     * 租赁方式
     * @return mixed
     */
    public function getFangClassAttribute()
    {
        return FangAttr::where('id', $this->attributes['fang_rent_class'])->value('name');
    }

    /**
     * 朝向
     * @return mixed
     */
    public function getDirectionAttribute()
    {
        return FangAttr::where('id', $this->attributes['fang_direction'])->value('name');
    }

    /**
     * 图片
     * @return string
     */
    public function getPicAttribute()
    {
        $arr = explode('#', $this->attributes['fang_pic']);
        return config('url.domain') . $arr[0];
    }

    /**
     * 几室几厅
     * @return string
     */
    public function getShiTingAttribute()
    {
        return $this->attributes['fang_shi'] . '室' . $this->attributes['fang_ting'] . '厅';
    }

    //修改器

    /**
     * 房屋配置
     * @param $value
     */
    public function setShiTingAttribute($value)
    {
        $this->attributes['fang_config'] = implode(',', $value);
    }

    /**
     * 房屋图片
     * @param $value
     */
    public function setFangPicAttribute($value)
    {
        $this->attributes['fang_pic'] = trim($value, '#');
    }

    // 访问器
    // 房源配置
    public function getFangConfAttribute()
    {
        return explode(',', $this->attributes['fang_config']);
    }

    // 房源图片配置
    public function getImagesAttribute()
    {
        $arr = explode('#', $this->attributes['fang_pic']);
        $html = '';
        foreach ($arr as $item) {
            $html .= "<img src='$item' style='width: 100px;' />&nbsp;&nbsp;";
        }
        return $html;
    }

    /**
     * 获取关联数据
     * @return array
     */
    public function relationData()
    {
        //业主信息
        $ownerData = FangOwner::get();
        //省份
        $cityData = City::where('pid', 0)->get();
        //租期方式
        $fang_rent_type_id = FangAttr::where('field_name', 'fang_rent_type')->value('id');
        $fang_rent_type_data = FangAttr::where('pid', $fang_rent_type_id)->get();
        //朝向
        $fang_direction_id = FangAttr::where('field_name', 'fang_direction')->value('id');
        $fang_direction_data = FangAttr::where('pid', $fang_direction_id)->get();
        //租赁方式
        $fang_rent_class_id = FangAttr::where('field_name', 'fang_rent_class')->value('id');
        $fang_rent_class_data = FangAttr::where('pid', $fang_rent_class_id)->get();
        //配套设施
        $fang_config_id = FangAttr::where('field_name', 'fang_config')->value('id');
        $fang_config_data = FangAttr::where('pid', $fang_config_id)->get();

        return [
            'ownerData' => $ownerData,
            'cityData' => $cityData,
            'fang_rent_type_data' => $fang_rent_type_data,
            'fang_direction_data' => $fang_direction_data,
            'fang_rent_class_data' => $fang_rent_class_data,
            'fang_config_data' => $fang_config_data
        ];
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
