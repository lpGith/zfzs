<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/5/27
 * Time: 16:59
 */

namespace App\Model;


class Article extends Base
{
    //追加字段
    protected $appends = ['action'];

    //访问器
    public function getActionAttribute()
    {
        return $this->editBtn('admin.article.edit') . $this->deleteBtn('admin.article.destroy');
    }
}
