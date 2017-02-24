<?php


/* 后台首页 */
Route::get('index/', [
    'as' => 'backend.index.index',
    'uses' => 'IndexController@index',
]);
/* 后台首页 */
Route::get('welcome/', [
    'as' => 'backend.index.welcome',
    'uses' => 'IndexController@welcome',
]);
/* 菜单管理模块 */
Route::get('menu/search', [
    'as' => 'backend.menu.search',
    'uses' => 'MenuController@search',
    'middleware' => ['search'],
]);
Route::resource('menu', 'MenuController');

/* 用户管理模块 */
Route::resource("user", 'UserController');
Route::get('userCenter/show', [
	'as' => 'backend.userCenter.show',
	'uses' => 'UserController@myInfo'
]);
Route::get('userCenter/editPwd', [
	'as' => 'backend.userCenter.editPwd',
	'uses' => 'UserController@editPwd'
]);
Route::put('userCenter/editPwd', [
	'as' => 'backend.userCenter.editPwdHandler',
	'uses' => 'UserController@editPwdHandler'
]);
Route::get('userCenter/bindOpenID', [
	'as' => 'backend.userCenter.bindOpenID',
	'uses' => 'UserController@bindOpenID'
]);
Route::put('userCenter/removeBind', [
	'as' => 'backend.userCenter.removeBind',
	'uses' => 'UserController@removeBind'
]);



/* 角色管理模块 */
Route::get('role/permission/{id}', [
    'as' => 'backend.role.permission',
    'uses' => 'RoleController@permission',
]);
Route::post('role/associatePermission', [
    'as' => 'backend.role.associate.permission',
    'uses' => 'RoleController@associatePermission',
]);
Route::resource("role", 'RoleController');

/* 权限管理模块 */
Route::get('permission/associate/{id}', [
    'as' => 'backend.permission.associate',
    'uses' => 'PermissionController@associate',
]);
Route::post('permission/associateMenus', [
    'as' => 'backend.permission.associate.menus',
    'uses' => 'PermissionController@associateMenus',
]);
Route::post('permission/associateActions', [
    'as' => 'backend.permission.associate.actions',
    'uses' => 'PermissionController@associateActions',
]);
Route::resource("permission", 'PermissionController');

/* 操作管理模块 */
Route::resource('action', 'ActionController');

/* 文件管理模块 */
Route::get('file', [
    'as' => 'backend.file.index',
    'uses' => 'FileController@index',
]);
Route::post('file/upload', [
    'as' => 'backend.file.upload',
    'uses' => 'FileController@upload',
]);

/* 人保车险分期模块 */
Route::get('rbcx/chargeLog', [
    'as' => 'backend.rbcx.charge.log',
    'uses' => 'RbcxController@chargeLog',
]);
Route::get('rbcx/getImgWithSignature/{id}/{signature_id}', [
    'as' => 'backend.rbcx.img.signature',
    'uses' => 'RbcxController@getImgWithSignature',
]);
Route::get('rbcx', [
    'as' => 'backend.rbcx.index',
    'uses' => 'RbcxController@index',
]);

Route::get('rbcx/show/{id}', [
    'as' => 'backend.rbcx.show',
    'uses' => 'RbcxController@show',
]);
Route::post('rbcx/picture/', [
    'as' => 'backend.rbcx.picture',
    'uses' => 'RbcxController@picture',
]);
Route::get('rbcx/signatureCheck', [
    'as' => 'backend.rbcx.signatureCheck',
    'uses' => 'RbcxController@signatureCheck'
]);
Route::get('rbcx/startPay', [
    'as' => 'backend.rbcx.startPay',
    'uses' => 'RbcxController@startPay'
]);
Route::get('rbcx/payConfirm', [
    'as' => 'backend.rbcx.payConfirm',
    'uses' => 'RbcxController@payConfirm'
]);
Route::get('rbcx/payConfirmAction', [
    'as' => 'backend.rbcx.payConfirmAction',
    'uses' => 'RbcxController@payConfirmAction'
]);
Route::get('rbcx/errorList',[
    'as' => 'backend.rbcx.errorList',
    'uses' => 'RbcxController@errorList'
]);
Route::get('rbcx/pureTest', [
    'as' => 'backend.rbcx.pureTest',
    'uses' => 'RbcxController@pureTest'
]);
Route::get('rbcx/signatureImg', [
    'as' => 'backend.rbcx.signatureImg',
    'uses' => 'RbcxController@pureSignatureImg'
]);
Route::get('rbcx/correctError', [
    'as' => 'backend.rbcx.correctError',
    'uses' => 'RbcxController@correctError'
]);
Route::get('rbcx/chargeInstallment', [
    'as' => 'backend.rbcx.chargeInstallment',
    'uses' => 'RbcxController@chargeInstallment'
]);
Route::get('rbcx/recoverFreeze',[
    'as' => 'backend.rbcx.recoverFreeze',
    'uses' => 'RbcxController@recoverFreeze'
]);


Route::get('rbcx/export', [
    'as' => 'backend.rbcx.export',
    'uses' => 'RbcxController@export',
]);




/* 净水器业务员管理模块 */
Route::resource('waterSale', 'WaterSaleController');

/*净水器订单来源渠道管理模块*/
Route::group([
	'namespace' => 'WaterPurifier',
], function (){
	Route::get('channel/index', [
		'as' => 'backend.channel.index',
		'uses' => 'ChannelController@index',
	]);
	Route::get('channel/create', [
		'as' => 'backend.channel.create',
		'uses' => 'ChannelController@create',
	]);
	Route::post('channel/store', [
		'as' => 'backend.channel.store',
		'uses' => 'ChannelController@store',
	]);
	Route::get('channel/show/{id}', [
		'as' => 'backend.channel.show',
		'uses' => 'ChannelController@show',
	]);
	Route::get('channel/edit/{id}', [
		'as' => 'backend.channel.edit',
		'uses' => 'ChannelController@edit',
	]);
	Route::put('channel/edit/{id}', [
		'as' => 'backend.channel.update',
		'uses' => 'ChannelController@update',
	]);
	Route::delete('channel/{id}', [
		'as' => 'backend.channel.destroy',
		'uses' => 'ChannelController@destroy',
	]);
});



/* 净水器订单管理模块 */
Route::group([
    'prefix' => 'waterPurifier',
], function () {
    require_once __DIR__ . '/Backend/waterPurifier.php';
});

Route::resource('waterPurifier', 'WaterPurifierController');

/* 合同管理 */
require_once __DIR__ . '/Backend/contract.php';

/* 车险分期 */
Route::group([
    'prefix' => 'carInsurance',
    'namespace' => 'CarInsurance',
], function () {
    require_once __DIR__ . '/Backend/carInsurance.php';
});


// 用户操作日志
Route::get("actionLogger/index", [
    'as' => 'backend.actionLogger.index',
    'uses' => "ActionLoggerController@index"
]);
Route::get("actionLogger/show", [
    'as' => 'backend.actionLogger.show',
    'uses'=> 'ActionLoggerController@show'
]);

//消息管理
Route::get('message/index', [
    'as' => 'backend.message.index',
    'uses' => 'MessageController@index'
]);
Route::get('message/read', [
    'as' => 'backend.message.read',
    'uses' => 'MessageController@read'
]);
Route::get('message/ask', [
    'as' => 'backend.message.ask',
    'uses' => 'MessageController@ask'
]);
Route::get('message/readAll', [
    'as' => 'backend.message.readAll',
    'uses' => 'MessageController@readAll'
]);


/* 短信 */
Route::group([
    'prefix'     => 'sms',
    'namespace'  => 'Sms',
], function () {
    require_once __DIR__ . '/Backend/sms.php';
});

/* 金融合同管理 */
Route::group([
    'prefix'     => 'financial',
    'namespace'  => 'Financial',
], function () {
	require_once __DIR__ . '/Backend/financial.php';
});

/* 微信 */
Route::group([
    'prefix'     => 'wechat',
    'namespace'  => 'WxPlatform',
], function () {
    require_once __DIR__ . '/Backend/wxplatform.php';
});



