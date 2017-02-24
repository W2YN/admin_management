<?php

/* 首页 */
Route::get('order', [
    'as' => 'backend.carInsurance.order.index',
    'uses' => 'OrderController@index',
]);

/* 显示页 */
Route::get('order/{id}', [
    'as' => 'backend.carInsurance.order.show',
    'uses' => 'OrderController@show',
]);

/* 显示编辑页 */
Route::get('order/{id}/edit', [
    'as' => 'backend.carInsurance.order.edit',
    'uses' => 'OrderController@edit',
]);

/*Route::get('order/{{id}}/commonEdit', [
    'as' => 'backend.carInsurance.order.edit',
    'uses' => 'OrderController@edit'
]);*/

/* 编辑提交处理 */
Route::put('order/{id}', [
    'as' => 'backend.carInsurance.order.update',
    'uses' => 'OrderController@update',
]);


/* 删除处理 */
Route::delete('order/{id}', [
    'as' => 'backend.carInsurance.order.destroy',
    'uses' => 'OrderController@destroy',
]);

/* 订单创建 */
Route::get('create', [
    'as' => 'backend.carInsurance.create',
    'uses' => 'OrderController@create',
]);

/* 创建订单提交处理 */
Route::post('order', [
    'as' => 'backend.carInsurance.order.store',
    'uses' => 'OrderController@store',
]);

/*分期列表管理*/
Route::get('installments', [
    'as' => 'backend.carInsurance.installments',
    'uses' => 'OrderController@installments',
]);

/*扣款失败管理*/
Route::get('chargeBackFail', [
    'as' => 'backend.carInsurance.chargeBackFail',
    'uses' => 'OrderController@chargeBackFail',
]);


//Route::resource('order', 'OrderController');
Route::post('/ajaxUpload', [
    'as' => 'ajaxUpload',
    'uses' => 'OrderController@ajaxUpload'
]);

Route::get('showFile', [
    'as' => 'show',
    'uses' => 'OrderController@showFile'
]);
Route::get('ajaxPage', [
    'as' => 'ajaxPage',
    'uses' => 'OrderController@ajaxPage'
]);


Route::get('wxActivityStat', [
    'as' => 'backend.carInsurance.wxActivityStat',
    'uses' => 'OrderController@wxActivityStat'
]);

Route::get('ajaxWxStat', [
    'as' => 'backend.carInsurance.ajaxWxStat',
    'uses' => 'OrderController@ajaxWxStat'
]);

Route::get('download', [
    'as' => 'backend.carInsurance.order.download',
    'uses' => 'OrderController@download'
]);

Route::get('listen', [
    'as' => 'backend.carInsurance.order.listen',
    'uses' => 'OrderController@listen'
]);

Route::get('test', [
    'as' => 'backend.carInsurance.order.test',
    'uses' => 'TestController@test'
]);

Route::get('pureImg', [
    'as' => 'backend.carInsurance.order.pureImg',
    'uses' => 'OrderController@pureImg'
]);

Route::get('pendingOrder', [
        'as' => 'backend.carInsurance.order.pendingOrder',
        'uses' => 'OrderController@pendingOrder'
    ]
);

Route::get('myOrder', [
        'as' => 'backend.carInsurance.order.myOrder',
        'uses' => 'OrderController@myOrder'
    ]
);

Route::get('takeOrder', [
    'as' => 'backend.carInsurance.order.takeOrder',
    'uses' => 'OrderController@takeOrder'
]);

Route::get('setStatus', [
    'as' => 'backend.carInsurance.order.setStatus',
    'uses' => 'OrderController@setStatus'
]);

Route::get('checkStatus', [
    'as' => 'backend.carInsurance.order.checkStatus',
    'uses' => 'OrderController@checkStatus'
]);

Route::get('charge', [
    'as' => 'backend.carInsurance.order.charge',
    'uses' => 'OrderController@startPay'
]);

/*Route::get('insuranceMoney', [
    'as' => 'backend.carInsurance.order.insuranceMoney',
    'uses' => 'OrderController@insuranceMoney'
]);*/

Route::get('getRecommendId', [
    'as' => 'backend.carInsurance.order.getRecommendId',
    'uses' => 'OrderController@getRecommendId'
]);

Route::get('scheduledPay', [
    'as' => 'backend.carInsurance.order.scheduledPay',
    'uses' => 'OrderController@scheduledPay'
]);

Route::get('correctError', [
    'as' => 'backend.carInsurance.correctError',
    'uses' => 'OrderController@correctError'
]);