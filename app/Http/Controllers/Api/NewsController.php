<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/5/27
 * Time: 16:57
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\Article;
use App\Model\ArticleCount;
use Exception;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $pageSize = 5;

    public function __construct()
    {
        $this->pageSize = config('page.pageSize');
    }

    /**
     * 文章列表
     * @return mixed
     */
    public function index()
    {
        $field = ['id', 'title', 'desn', 'pic', 'created_at'];

        return Article::orderBy('id', 'desc')->select($field)->paginate($this->pageSize);
    }

    /**
     * 文章详情
     * @param Article $article
     * @return Article
     */
    public function show(Article $article)
    {
        return $article;
    }

    /**
     * 用户访问统计
     * @param Request $request
     * @param $article
     * @return array
     */
    public function Count(Request $request, $article)
    {
        $openid = $request->get('openid');
        $data = [
            'openid' => $openid,
            'art_id' => $article,
            'vdt' => date('Y-m-d'),
            'vtime' => time()
        ];

        try {
            $model = ArticleCount::create($data);
        } catch (Exception $exception) {
            return ['status' => 10006, 'msg' => '数据已存在'];
        }
        return $model;
    }

}
