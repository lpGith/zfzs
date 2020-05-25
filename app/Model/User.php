<?php

namespace App\Model;

use Illuminate\Foundation\Auth as AuthUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends AuthUser
{
    use SoftDeletes;

    protected $guarded = [];
}
