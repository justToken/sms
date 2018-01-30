<?php

Route::group(['middleware' => ['auth:admin']], function ($router) {
    $router->get('/', ['uses' => 'AdminController@index','as' => 'admin.index']);

    $router->resource('index', 'IndexController');

    //目录
    $router->resource('menus', 'MenuController');

    //后台用户
    $router->get('adminuser/ajaxIndex',['uses'=>'AdminUserController@ajaxIndex','as'=>'admin.adminuser.ajaxIndex']);
    $router->resource('adminuser', 'AdminUserController');

    //权限管理
    $router->get('permission/ajaxIndex',['uses'=>'PermissionController@ajaxIndex','as'=>'admin.permission.ajaxIndex']);
    $router->resource('permission', 'PermissionController');

    //角色管理
    $router->get('role/ajaxIndex',['uses'=>'RoleController@ajaxIndex','as'=>'admin.role.ajaxIndex']);
    $router->resource('role', 'RoleController');

    //机构管理
    $router->get('institution/ajaxIndex',['uses'=>'InstitutionController@ajaxIndex','as'=>'admin.institution.ajaxIndex']);
    $router->get('institution/servicenetwork',['uses'=>'InstitutionController@serviceNetwork','as'=>'admin.institution.servicenetwork']);
    $router->resource('institution', 'InstitutionController');

    //公众短信
    $router->get('message/ajaxIndex',['uses'=>'MessageController@ajaxIndex','as'=>'admin.message.ajaxIndex']);
    $router->resource('message', 'MessageController');

    //提醒通知
    $router->get('notice/ajaxIndex',['uses'=>'NoticeController@ajaxIndex','as'=>'admin.notice.ajaxIndex']);
    $router->get('notice/send/{id}',['uses'=>'NoticeController@send','as'=>'admin.notice.servicenetwork']);
    $router->resource('notice', 'NoticeController');

    //短信模板管理
    $router->get('sms/ajaxIndex',['uses'=>'SmsController@ajaxIndex','as'=>'admin.sms.ajaxIndex']);
    $router->resource('sms', 'SmsController');

    //用户组管理
    $router->get('usergroup/ajaxIndex',['uses'=>'UsergroupController@ajaxIndex','as'=>'admin.usergroup.ajaxIndex']);
    $router->resource('usergroup', 'UsergroupController');

    //套餐管理
    $router->get('package/ajaxIndex',['uses'=>'PackageController@ajaxIndex','as'=>'admin.package.ajaxIndex']);
    $router->resource('package', 'packageController');

    //用户管理
    $router->get('user/ajaxIndex',['uses'=>'UserController@ajaxIndex','as'=>'admin.user.ajaxIndex']);
    $router->get('user/black/{id?}',['uses'=>'UserController@blacklist','as'=>'admin.user.ajaxIndex']);
    $router->resource('user', 'UserController');

    //日志管理
    $router->get('log/ajaxIndex',['uses'=>'LogController@ajaxIndex','as'=>'admin.log.ajaxIndex']);
    $router->resource('log', 'LogController');

});

Route::get('login', ['uses' => 'AuthController@index','as' => 'admin.auth.index']);
Route::post('login', ['uses' => 'AuthController@login','as' => 'admin.auth.login']);

Route::get('logout', ['uses' => 'AuthController@logout','as' => 'admin.auth.logout']);

Route::get('register', ['uses' => 'AuthController@getRegister','as' => 'admin.auth.register']);
Route::post('register', ['uses' => 'AuthController@postRegister','as' => 'admin.auth.register']);

Route::get('password/reset/{token?}', ['uses' => 'PasswordController@showResetForm','as' => 'admin.password.reset']);
Route::post('password/reset', ['uses' => 'PasswordController@reset','as' => 'admin.password.reset']);
Route::post('password/email', ['uses' => 'PasswordController@sendResetLinkEmail','as' => 'admin.password.email']);
