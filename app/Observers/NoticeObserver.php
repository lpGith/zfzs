<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/5/27
 * Time: 15:31
 */

namespace App\Observers;


use App\Jobs\NoticeJob;

class NoticeObserver
{

    //添加完成后执行方法 create creating
    public function created()
    {
        dispatch(new NoticeJob());
    }

    //修改完成后，执行此方法 update updating
    public function updated(Notice $notice)
    {

    }
}
