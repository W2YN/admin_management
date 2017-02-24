<?php
Route::get('/', function () {
    return redirect('backend/index/');
});

/* 后台登录模块 */
Route::group(['namespace' => 'Auth'], function () {
    require_once __DIR__ . '/Routes/auth.php';
});

/* 前端管理模块 */
Route::group([
	'prefix' => 'frontend',
	'namespace' => 'Frontend',
], function () {
    require_once __DIR__ . '/Routes/frontend.php';
});

/* 后台管理模块 */
Route::group([
    'prefix'     => 'backend',
    'namespace'  => 'Backend',
    'middleware' => ['authenticate', 'authorize'],
], function () {
    require_once __DIR__ . '/Routes/backend.php';
});


/* 接口模块 */
Route::group([
    'prefix'     => 'api',
    'namespace'  => 'Api',
    'middleware' => ['apiAuthenticate'],
], function () {
    require_once __DIR__ . '/Routes/api.php';
});

Route::get('backend/userCenter/bindOpenIDHandler', [
	'as' => 'backend.userCenter.bindOpenIDHandler',
	'uses' => 'Backend\BindOpenController@bindOpenid'
]);
Route::put('backend/userCenter/bindOpenIDHandler', [
	'as' => 'backend.userCenter.bindOpenIDHandlerTrue',
	'uses' => 'Backend\BindOpenController@bindOpenidHandler'
]);
