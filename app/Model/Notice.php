<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/5/27
 * Time: 15:31
 */

namespace App\Model;


use App\Observers\NoticeObserver;

class Notice extends Base
{
    protected static function boot()
    {
        parent::boot();
        //注册自定义观察类
        self::observe(NoticeObserver::class);
    }

    //关联模型 房东
    public function owner()
    {
        return $this->belongsTo(FangOwner::class, 'fangowner_id');
    }
}
