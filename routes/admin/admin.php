<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/5/26
 * Time: 9:21
 */

//后台分组路由
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    //登录
    Route::get('login', 'LoginController@index')->name('admin.login');
    Route::post('login', 'LoginController@login')->name('admin.login');


    //后台中间件
    Route::group(['middleware' => 'ckAdmin', 'as' => 'admin.'], function () {

        //后台首页
        Route::get('index', 'IndexController@index')->name('index');
        //退出
        Route::get('logout', 'IndexController@logout')->name('logout');
        //文章列表
        Route::get('article/index', 'ArticleController@index')->name('article.index');
        //欢迎界面
        Route::get('welcome', 'IndexController@welcome')->name('welcome');

        //用户列表
        Route::get('user/index', 'UserController@index')->name('user.index');
        //用户添加
        Route::get('user/add', 'UserController@create')->name('user.create');
        Route::post('user/store', 'UserController@store')->name('user.store');
        //删除用户
        Route::delete('user/del/{$id}', 'UserController@del')->name('user.del');
        //还原用户
        Route::get('user/restore/{$id}', 'UserController@restore')->name('user.restore');
        //批量删除
        Route::delete('user/delAll', 'UserController@delAll')->name('user.delAll');
        Route::get('role', 'UserController@role')->name('user.role');

        //用户修改
        Route::get('user/edit/{$id}', 'UserController@edit')->name('user.edit');
        Route::put('user/update/{$id}', 'UserController@update')->name('user.update');


        //角色 资源路由
        Route::resource('role', 'RoleController');
        // 分配权限
        Route::get('role/node/{role}', 'RoleController@node')->name('role.node');
        Route::post('role/node/{role}', 'RoleController@nodeSave')->name('role.node');

        // 节点管理
        Route::resource('node', 'NodeController');

        //房源
        //改变房源状态
        Route::get('fang/ChangeStatus', 'FangController@ChangeStatus')->name('fang.ChangeStatus');
        Route::resource('fang', 'FangController');


        //房源属
        //文件上传
        Route::post('fang/upfile', 'FangAttrController@upfile')->name('fang.upfile');
        Route::resource('fangattr', 'FangAttrController');

        //房东信息
        Route::get('fangowner/exports', 'FangOwnerController@exports')->name('fangowner.exports');

        //文件上传
        Route::post('fangowner/upfile', 'FangOwnerController@upfile')->name('fangowner.upfile');
        Route::get('fangowner/delfile', 'FangOwnerController@delfile')->name('fangowner.delfile');

        Route::resource('fangowner', 'FangOwnerController');
        // 预约资源管理
        Route::resource('notice', 'NoticeController');

        Route::resource('apiuser', 'ApiUserController');
    });


});
