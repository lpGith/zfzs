<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/5/25
 * Time: 17:59
 */

namespace App\Observers;


use App\Model\Apiusers;

class ApiUserObserver
{
    //添加动作之前
    public function creating(Apiusers $apiUser)
    {
        $apiUser->password = bcrypt(request()->get('password'));
    }

}
