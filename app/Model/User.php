<?php

namespace App\Model;

use App\Model\Traits\Btn;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends AuthUser
{
    use SoftDeletes;
    use Btn;

    protected $dates = ['deleted_at'];

    protected $guarded = [];

    //隐藏字段
    protected $hidden = ['password'];

    //用户角色关联
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
