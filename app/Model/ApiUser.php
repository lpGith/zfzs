<?php

namespace App\Model;

use App\Observers\ApiUserObserver;
use IIlluminate\Foundation\Auth\User as UserAuth;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiUser extends UserAuth
{
    use SoftDeletes;


    //软删除标识字段
    protected $dates = ['deleted_at'];


    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        self::observer(ApiUserObserver::class);
    }
}
