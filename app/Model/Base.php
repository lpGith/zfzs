<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    protected $guarded = [];


    public function treeLevel($data, $pid = 0, $html = '--', $level = 0)
    {
        static $arr = [];
        if (is_array($data)) {
            foreach ($data as $v) {
                if ($pid == $v['id']) {
                    $v['html'] = str_repeat($html, $level * 2);
                    $v['level'] = $level + 1;
                    $arr[] = $v;
                    $this->treeLevel($data, $v['id'], $html, $v['level']);
                }
            }
        }
        return $arr;
    }


    /**
     * 获取多层级
     * @param $data
     * @param int $pid
     * @return array
     */
    public function subTree($data, $pid = 0)
    {
        $arr = [];
        if (is_array($data)) {
            foreach ($data as $v) {
                if ($pid == $v['pid']) {
                    $v['sub'] = $this->subTree($data, $v['id']);
                    $arr[] = $v;
                }
            }
        }
        return $arr;
    }


}
