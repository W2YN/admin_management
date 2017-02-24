<?php
/**
 * Created by PhpStorm.
 * User: 黄忠羽
 * Date: 2016/8/4
 * Time: 13:15
 */

Route::any('sms/send', [
    'as'         => 'api.sms.send',
    'uses'       => 'SmsController@send',
]);


Route::get('sms/test', [
    'as'         => 'api.sms.test',
    'uses'       => 'SmsController@test',
]);