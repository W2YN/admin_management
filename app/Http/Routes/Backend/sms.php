<?php
/**
 * Created by PhpStorm.
 * User: Huangzhongyu
 * Date: 2016/10/27
 * Time: 10:10
 */

/*短信列表*/
Route::get('index', [
	'as' => 'backend.sms.index',
	'uses' => 'SmsController@index'
]);

/*删除短信*/
Route::delete('/{id}', [
	'as' => 'backend.sms.destory',
	'uses' => 'SmsController@destroy',
]);