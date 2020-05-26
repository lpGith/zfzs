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
