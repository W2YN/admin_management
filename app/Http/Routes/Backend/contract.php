<?php
//理财还本明细单
Route::get('contract/capitalBills', [
    'as' => 'backend.contract.capitalBills',
    'uses' => 'ContractController@capitalBills'
]);

//利息支付明细表
Route::get('contract/interestBills', [
    'as' => 'backend.contract.interestBills',
    'uses' => 'ContractController@interestBills'
]);

/* 合同管理 导出 */
Route::get('contract/export', [
    'as' => 'backend.contract.export',
    'uses' => 'ContractController@export',
]);
/* 合同管理 导出汇款文档 */
Route::get('contract/exportRemittance', [
    'as' => 'backend.contract.exportRemittance',
    'uses' => 'ContractController@exportRemittance',
]);
/* 合同管理 确认合同 */
Route::post('contract/confirm/{id}', [
    'as' => 'backend.contract.confirm',
    'uses' => 'ContractController@confirm',
]);
/* 合同管理 确认合同 */
Route::get('contract/payment', [
    'as' => 'backend.contract.payment',
    'uses' => 'ContractController@payment',
]);
Route::get('contract/dimensionCount', [
    'as' => 'backend.contract.dimensionCount',
    'uses' => 'ContractController@dimensionCount'
]);

/* 合同管理 */
Route::resource('contract', 'ContractController');
/* 合同管理 收据 */
Route::get('contract/receipt/{id}', [
    'as'   => 'backend.contract.receipt',
    'uses' => 'ContractController@receipt',
]);
/* 合同管理 收据 */
Route::get('contract/confirmation/{id}', [
    'as' => 'backend.contract.confirmation',
    'uses' => 'ContractController@confirmation',
]);
/* 合同管理 确认已支付 */
Route::post('contract/payed/{id}', [
    'as' => 'backend.contract.payed',
    'uses' => 'ContractController@payed',
]);

