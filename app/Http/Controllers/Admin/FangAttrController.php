<?php

namespace App\Http\Controllers\Admin;

use App\Model\Fangattr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FangAttrController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Fangattr $fangAttr
     * @return void
     */
    public function index(Fangattr $fangAttr)
    {
        $data = $fangAttr->getList();
        return view('admin.fangattr.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //获取顶级属性
        $data = Fangattr::where('pid', 0)->get();

        return view('admin.fangattr.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        //表单验证
        $this->validate($request, [
            'name' => 'required'
        ]);

        $data = $request->except(['_token', 'file']);
        $data['field_name'] = !empty($data['field_name']) ? $data['field_name'] : '';

        Fangattr::create($data);
        return view('admin.fangattr.index');
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
     * 文件上传
     * @param Request $request
     * @return array
     */
    public function upfile(Request $request)
    {
        //mor图标
        $pic = config('up.pic');
        if ($request->hasFile('file')) {
            $ret = $request->file('file')->store('', 'fangattr');
            $pic = '/uploads/fangattr/' . $ret;
        }

        return ['status' => 0, 'url' => $pic];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Fangattr $fangAttr
     * @return void
     */
    public function edit(Fangattr $fangAttr)
    {
        //获取顶级属性
        $data = $fangAttr->where('pid', 0)->get();
        return view('admin.fangattr.edit', compact('data', 'fangAttr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Fangattr $fangAttr
     * @return void
     * @throws ValidationException
     */
    public function update(Request $request, Fangattr $fangAttr)
    {
        //表单验证
        $this->validate($request, [
            'name' => 'required'
        ]);

        $data = $request->except(['_token', 'file', '_method']);

        $data['field_name'] = !empty($data['field_name']) ? $data['field_name'] : '';

        $fangAttr->update($data);
        return view('admin.fangattr.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Fangattr $fangAttr
     * @return array
     * @throws Exception
     */
    public function destroy(Fangattr $fangAttr)
    {
        //
        $fangAttr->delete();
        return ['status' => 0, 'msg' => '房屋属性删除成功'];
    }
}
