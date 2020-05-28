<?php

namespace App\Http\Controllers\Admin;

use App\Model\City;
use App\Model\Fang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class FangController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Fang::with(['owner'])->paginate($this->pageSize);
        return view('admin.fang.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //获取关联表数据
        $data = (new Fang())->relationData();
        return view('admin.fang.create', compact('data'));
    }

    /**
     * 获取城市
     * @param Request $request
     * @return mixed
     */
    public function City(Request $request)
    {
        return City::where('pid', $request->get('id'))->get(['id', 'name']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
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
     * 修改房源状态
     * @param Request $request
     * @return array
     */
    public function ChangeStatus(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');

        Fang::where('id', $id)->update(['fang_status' => $status]);
        return ['status' => 0, 'mag' => '修改房源状态成功'];
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
