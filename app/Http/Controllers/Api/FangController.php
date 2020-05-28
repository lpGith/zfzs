<?php

namespace App\Http\Controllers\Api;

use App\Model\Fang;
use App\Model\Fangattr;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FangController extends Controller
{
    /**
     * 房源推荐
     * @return mixed
     */
    public function GetRecommend()
    {
        $field = 'id,fang_name,fang_pic,fang_shi,fang_ting';
        return Fang::where('is_recommend', 1)->orderBy('id', 'DESC')->limit(5)->get($field);
    }

    /**
     * 房源属性
     * @param Request $request
     * @return mixed
     */
    public function GetAttrs(Request $request)
    {
        //要获取的属性
        $field_name = $request->get('field');

        $id = Fangattr::where('field_name', $field_name)->value('id');

        return Fangattr::where('pid', $id)->limit(4)->get(['id', 'name', 'icon']);
    }

    /**
     * 房源列表
     * @param Request $request
     * @return mixed
     */
    public function GetFangList(Request $request)
    {
        $field = 'id,fang_name,fang_pic,fang_shi,fang_ting,fang_rent,fang_build_area';

        $ret = Fang::select($field);

        //条件过滤
        if ($request->get('fieldname')) {
            $ret->where($request->get('fieldname'), $request->get('fielvalue'));
        }
        return $ret->paginate(10);
    }

    /**
     * 房源详情
     * @param Fang $fang
     * @return Fang
     */
    public function GetFangDeatil(Fang $fang)
    {
        //获取房东
        $owner = $fang->owner();

        //房屋配置
        $configAttr = explode(',', $fang->fang_config);
        $fang->config = Fangattr::whereIn('id', $configAttr)->get(['id', 'name', 'icon']);

        //房屋朝向
        $fang->direction = Fangattr::where('id', $fang->fang_direction)->value('name');

        //房屋图片
        $fang->picList = array_map(function ($item) {
            return config('url.domain') . $item;
        }, explode('#', $fang->fang_pic));

        return $fang;
    }

    /**
     * 关键字查询
     * @param Request $request
     * @return array
     */
    public function EsSearch(Request $request)
    {
        //根据关键字查询
        $kw = $request->get('kw');
        if (empty($kw)) {
            return ['status' => 10009, 'msg' => '没有存数据', 'data' => []];
        }

        //es查询  Elasticsearch
        $client = ClientBuilder::create()->setHosts(config('es.host'))->build();

        //查询参数
        $params = [
            'index' => 'fang',
            'type' => '_doc',
            'body' => [
                'query' => [
                    'match' => [
                        'fang_desn' => [
                            'query' => $kw,
                        ]
                    ]
                ]
            ]
        ];

        //查询
        $ret = $client->search($params);
        $total = $ret['hits']['total'];

        if ($total > 0) {
            $ids = array_column($ret['hits']['hits'], '_id');

            $field = 'id,fang_name,fang_shi,fang_ting,fang_pic,fang_build_area,fang_rent';

            return Fang::select($field)->whereIn('id', $ids)->paginate(10);

        } else {
            return ['status' => 10009, 'msg' => '没有存数据', 'data' => []];
        }
    }

}
