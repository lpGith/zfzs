<?php

namespace App\Http\Controllers\Admin;

use App\Model\Node;
use App\Model\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //搜索条件
        $name = $request->get('name', '');

        $data = Role::when($name, function ($query) use ($name) {
            $query->where('name', 'like', "%{$name}%");
        })->paginate($this->pageSize);

        return view('admin.role.index', compact('data', 'name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|unique:roles,name',
            ]);
        } catch (ValidationException $e) {
            return ['status' => -1, 'msg' => '验证不通过'];
        }

        Role::create($request->only('name'));
        return ['status' => 0, 'msg' => '添加角色成功'];
    }

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
        $model = Role::find($id);
        return view('admin.role.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'name' => 'required|unique:roles,name',
            ]);
        } catch (ValidationException $e) {
            return ['status' => -1, 'msg' => '验证不通过'];
        }

        Role::where('id', $id)->updte(['name' => $request->only('name')]);
        return ['status' => 0, 'msg' => '修改角色成功'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return array
     */
    public function destroy($id)
    {
        Role::destroy($id);
        return ['status' => 0, 'msg' => '删除角色成功'];
    }

    /**
     * 给角色分配权限
     * @param Role $role
     * @return Application|Factory|View
     */
    public function node(Role $role)
    {
        //获取所有权限节点
        $nodeAll = (new Node())->getList();
        //当前角色拥有的权限
        $nodes = $role->nodes()->pluck('id')->toArray();
        return view('admin.role.node', compact('role', 'nodeAll', 'nodes'));
    }


    /**
     * 角色权限分配处理
     * @param Request $request
     * @param Role $role
     * @return Application|RedirectResponse|Redirector
     */
    public function nodeSave(Request $request, Role $role)
    {
        //关联模型数据同步
        $role->nodes()->sync($request->get('node'));
        return redirect(route('admin.role.node', $role));
    }
}
