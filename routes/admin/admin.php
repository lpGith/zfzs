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
    Route::group(['middleware' => 'ckAdmin'], function () {

        //后台首页
        Route::get('index', 'IndexController@index')->name('admin.index');
        //退出
        Route::get('logout', 'IndexController@logout')->name('admin.logout');
        //文章列表
        Route::get('article/index', 'ArticleController@index')->name('admin.article.index');
        //欢迎界面
        Route::get('welcome', 'IndexController@welcome')->name('admin.welcome');

        //用户列表
        Route::get('user/index', 'UserController@index')->name('admin.user.index');
        //用户添加
        Route::get('user/add', 'UserController@create')->name('admin.user.create');
        Route::post('user/store', 'UserController@store')->name('admin.user.store');
        //删除用户
        Route::delete('user/del/{$id}', 'UserController@del')->name('admin.user.del');
        //还原用户
        Route::get('user/restore/{$id}', 'UserController@restore')->name('admin.user.restore');
        //批量删除
        Route::delete('user/delAll', 'UserController@delAll')->name('admin.user.delAll');
        Route::get('role', 'UserController@role')->name('admin.user.role');

        //用户修改
        Route::get('user/edit/{$id}', 'UserController@edit')->name('admin.user.edit');
        Route::put('user/update/{$id}', 'UserController@update')->name('admin.user.update');


        //角色 资源路由
        Route::resource('role', 'RoleController');
        // 分配权限
        Route::get('role/node/{role}', 'RoleController@node')->name('admin.role.node');
        Route::post('role/node/{role}', 'RoleController@nodeSave')->name('admin.role.node');


        //房源
        //改变房源状态
        Route::get('fang/ChangeStatus', 'FangController@ChangeStatus')->name('admin.fang.ChangeStatus');
        Route::resource('fang', 'FangController');


        //房源属性
        Route::resource('fangattr', 'FangAttrController');
        //文件上传
        Route::post('fang/upfile', 'FangAttrController@upfile')->name('admin.fang.upfile');

        //房东信息
        Route::resource('fangowner', 'FangOwnerController');
        //文件上传
        Route::post('fangowner/upfile', 'FangOwnerController@upfile')->name('admin.fangowner.upfile');
        Route::get('fangowner/delfile', 'FangOwnerController@delfile')->name('admin.fangowner.delfile');
        Route::get('fangowner/exports', 'FangOwnerController@exports')->name('admin.fangowner.exports');

        // 预约资源管理
        Route::resource('notice','NoticeController');
    });


});
