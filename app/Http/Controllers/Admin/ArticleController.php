<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddArtRequest;
use App\Model\Article;
use Exception;
use Illuminate\Http\Request;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        //ajax请求
        if ($request->header('X-Requested-With') == 'XMLHttpRequest') {

//            ['column'=>$column,'dir'=>$dir] = $request->get('order')[0];
            $orderArr = $request->get('order')[0];

            //排序索引
            $column = $orderArr['column'];

            //排序方式
            $dir = $orderArr['dir'];
            //排序字段
            $orderFiled = $request->get('columns')[$column]['data'];

            //开启位置
            $start = $request->get('start', 0);

            //开始时间
            $datemin = $request->get('datemin');
            //结束时间
            $datemax = $request->get('datemax');
            //搜索关键字
            $kw = $request->get('title');

            //查询对象
            $query = Article::where('id', '>', 0);

            //日期
            if (!empty($datemin) && !empty($datemax)) {
                //开始日期
                $datemin = date('Y-m-d H:i:s', strtotime($datemin . '00:00:00'));
                //结束时间
                $datemax = date('Y-m-d H:i:s', strtotime($datemax . '23:59:59'));

                $query->whereBetween('created_at', [$datemin, $datemax]);
            }

            //关键字搜索
            if (!empty($kw)) {
                $query->where('title', 'like', '%{$kw}%');
            }

            //获取记录数
            $length = min(100, $request->get('length', 10));

            //记录总数
            $total = Article::count();

            //获取数据
            $data = $query->orderBy($orderFiled, $dir)->offset($start)->limit($length)->get();

            /*
            draw: 客户端调用服务器端次数标识
            recordsTotal: 获取数据记录总条数
            recordsFiltered: 数据过滤后的总数量
            data: 获得的具体数据
            注意：recordsTotal和recordsFiltered都设置为记录的总条数
            */
            return [
                'draw' => $request->get('draw'),
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $data
            ];
        }

        return view('admin.article.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('admin.article.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddArtRequest $request
     * @return void
     */
    public function store(AddArtRequest $request)
    {
        $data = $request->except(['_token', 'file']);

        Article::create($data);

        return redirect(route('admin.article.index'));
    }


    /**
     * 文章封面图上传
     * @param Request $request
     * @return array
     */
    public function upfile(Request $request)
    {
        $pic = config('up.pic');
        if ($request->hasFile('file')) {
            $ret = $request->file('file')->store('', 'article');
            $pic = '/uploads/article/' . $ret;
        }

        return ['status' => 0, 'url' => $pic];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return array
     * @throws Exception
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return ['status' => 0, 'msg' => '删除文章成功'];
    }
}
