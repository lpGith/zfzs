<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FangOwnerExport;
use App\Model\FangOwner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;


class FangOwnerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $data = FangOwner::paginate($this->pageSize);
        return view('admin.fangowner.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.fangowner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //表单验证
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required'
        ]);

        $data = $request->except(['_token', 'file']);

        //图片处理
        $data['pic'] = trim($data['pic'], '#');

        FangOwner::create($data);
        return redirect(route('admin.fangowner.index'));
    }

    /**
     * 文件上传
     * @param Request $request
     * @return array
     */
    public function upfile(Request $request)
    {
        //默认图片
        $pic = config('up.pic');
        if ($request->hasFile('file')) {
            $ret = $request->file('file')->store('', 'fangowner');
            $pic = '/uploads/fangowner/' . $ret;
        }
        return ['status' => 0, 'url' => $pic];
    }


    /**
     * 文件删除
     * @param Request $request
     * @return array
     */
    public function defile(Request $request)
    {
        $file = $request->get('file');
        //获取文件真实路径
        $filePath = public_path() . $file;

        unlink($filePath);
        return ['status' => 0, 'msg' => '删除成功'];
    }

    /**
     * Display the specified resource.
     *
     * @param FangOwner $fangOwner
     * @return void
     */
    public function show(FangOwner $fangOwner)
    {
        //图片列表
        $picList = explode('#', $fangOwner->pic);
        array_map(function ($item) {
            echo "<div><img src=$item width='150px;'/></div>";
        }, $picList);

        return '';
    }

    /**
     * 文件导出
     */
    public function exports()
    {
        Excel::download(new FangOwnerExport(), 'fangdong.xlsx');
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
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
