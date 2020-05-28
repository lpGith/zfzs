<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/5/26
 * Time: 10:21
 */

namespace App\Model;


class Node extends Base
{

    //获取所有权限节点
    public function getList()
    {
        $data = self::get()->toArray();
        return $this->treeLevel($data);
    }

    public function treeData($node)
    {
        $nodeObj = Node::where('is_menu', '1');
        if (is_array($node)) {
            $nodeObj->whereIn('id', array_keys($node));
        }

        $data = $nodeObj->get()->toArray();

        return $this->subTree($data);
    }
}
