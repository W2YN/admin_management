<?php

/* 厂商安装时间更新 */
Route::post('updateInstallTime/{id}', [
    'as' => 'backend.waterPurifier.updateInstallTime',
    'uses' => 'WaterPurifierController@updateInstallTime',
]);
/*设备设为已安装*/
Route::put('setInstalled/{id}', [
	'as' => 'backend.waterPurifier.setInstalled',
	'uses' => 'WaterPurifierController@setInstalled',
]);

/* 设备维护设为已维护 */
Route::post('maintainComplete', [
    'as' => 'backend.waterPurifier.maintainComplete',
    'uses' => 'WaterPurifierController@maintainComplete',
]);
/*数据统计*/
Route::get('wxActivityStat', [
    'as' => 'backend.waterPurifier.wxActivityStat',
    'uses' => 'WaterPurifierController@wxActivityStat'
]);


Route::post('failDetail', [
    'as' => 'backend.waterPurifier.failDetail',
    'uses' => 'WaterPurifierController@failDetail'
]);
Route::get('eventSource', [
    'as' => 'backend.waterPurifier.eventSource',
    'uses' => 'WaterPurifierController@eventSource'
]);

Route::get('installmentCollect', [
    'as' => 'backend.waterPurifier.installmentCollect',
    'uses' => 'WaterPurifierController@installmentCollect'
]);

/* 设备信息*/
Route::get('deviceInfo', [
    'as' => 'backend.waterPurifier.deviceInfo',
    'uses' => 'WaterPurifierController@deviceInfo'
]);

/* 扣款失败信息 */
Route::get('chargeBackFail', [
    'as' => 'backend.waterPurifier.chargeBackFail',
    'uses' => 'WaterPurifierController@chargeBackFail'
]);

/* 分期信息列表 */
Route::get('installments', [
    'as' => 'backend.waterPurifier.installments',
    'uses' => 'WaterPurifierController@installments',
]);
/* 净水器订单后台添加 */
Route::get('orderCreate', [
	'as' => 'backend.waterPurifier.order.create',
	'uses' => 'WaterPurifierController@orderCreate',
]);
/* 创建订单提交处理 */
Route::post('order', [
	'as' => 'backend.waterPurifier.order.store',
	'uses' => 'WaterPurifierController@orderStore',
]);