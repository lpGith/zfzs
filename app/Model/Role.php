<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //关联权限节点 多对多关系
    public function nodes()
    {
        return $this->belongsToMany(Node::class, 'role_node', 'role_id', 'node_id');
    }
}
