<?php

namespace App\Model;

use App\Model\Traits\Btn;
use App\Observers\ApiUserObserver;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class Apiusers extends AuthUser
{
    use SoftDeletes, HasApiTokens, Btn;


    //软删除标识字段
    protected $dates = ['deleted_at'];


    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        self::observe(ApiUserObserver::class);
    }
}
