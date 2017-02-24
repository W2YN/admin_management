<?php

//所有快递信息列表
Route::get('express', [
    'as' => 'backend.financial.express',
    'uses' => 'ExpressController@index',
]);

//快递详情
Route::get('express/{id}', [
    'as' => 'backend.financial.express.show',
    'uses' => 'ExpressController@show',
])->where('id', '[0-9]+');

//添加一条快递记录视图
Route::get('express/create', [
    'as' => 'backend.financial.express.create',
    'uses' => 'ExpressController@create',
]);

//添加一条快递记录存储操作
Route::post('express/store', [
    'as' => 'backend.financial.express.store',
    'uses' => 'ExpressController@store',
]);



//所有合同列表
Route::get('contract', [
    'as' => 'backend.financial.contract',
    'uses' => 'ContractController@index',
]);

//合同详情
Route::get('contract/{id}', [
    'as' => 'backend.financial.contract.show',
    'uses' => 'ContractController@show',
])->where('id', '[0-9]+');

//将合同设为异常状态
Route::put('contract/{id}', [
    'as' => 'backend.financial.contract.update',
    'uses' => 'ContractController@update',
])->where('id', '[0-9]+');

//将合同设为以回邮状态
Route::put('contract/expressBack/{id}', [
    'as' => 'backend.financial.contract.expressBack',
    'uses' => 'ContractController@expressBack',
])->where('id', '[0-9]+');

//将合同设为存档状态
Route::put('contract/keepInTheArchives/{id}', [
    'as' => 'backend.financial.contract.keepInTheArchives',
    'uses' => 'ContractController@keepInTheArchives',
])->where('id', '[0-9]+');




//所有金融端用户列表
Route::get('user', [
    'as' => 'backend.financial.user',
    'uses' => 'UserController@index',
]);













