<?php
/**
 * Created by PhpStorm.
 * User: hangaoyu
 * Date: 16/12/2
 * Time: 下午1:09
 */
/* 微信回复消息 */
Route::get('index', [
    'as' => 'backend.wxmessage.index',
    'uses' => 'MessageController@index',
]);
Route::delete('destory/{id}', [
    'as' => 'backend.wxmessage.destory',
    'uses' => 'MessageController@destory',
]);
Route::get('create', [
    'as' => 'backend.wxmessage.create',
    'uses' => 'MessageController@create',
]);

Route::post('store', [
    'as' => 'backend.wxmessage.store',
    'uses' => 'MessageController@store',
]);

Route::get('edit/{id}', [
    'as' => 'backend.wxmessage.edit',
    'uses' => 'MessageController@edit',
]);
Route::post('update/{id}', [
    'as' => 'backend.wxmessage.update',
    'uses' => 'MessageController@update',
]);

///* 微信回复事件 */
Route::get('event', [
    'as' => 'backend.wxevent.index',
    'uses' => 'EventController@index',
]);

Route::post('eventPicture', [
    'as' => 'backend.wxevent.picture',
    'uses' => 'MessageController@picture',
]);
Route::get('eventEdit/{id}', [
    'as' => 'backend.wxevent.edit',
    'uses' => 'EventController@edit',
]);
Route::post('eventUpdate/{id}', [
    'as' => 'backend.wxevent.update',
    'uses' => 'EventController@update',
]);

///* 微信用户 */
Route::get('user', [
    'as' => 'backend.wxuser.index',
    'uses' => 'WxUserController@index',
]);

///* 微信用户 */
Route::get('notice', [
    'as' => 'backend.wxnotice.index',
    'uses' => 'WxNoticeController@index',
]);
Route::get('noticeCreate', [
    'as' => 'backend.wxnotice.create',
    'uses' => 'WxNoticeController@create',
]);

Route::post('noticeStore', [
    'as' => 'backend.wxnotice.store',
    'uses' => 'WxNoticeController@store',
]);
Route::get('noticeEdit/{id}', [
    'as' => 'backend.wxnotice.edit',
    'uses' => 'WxNoticeController@edit',
]);

Route::post('noticeUpdate/{id}', [
    'as' => 'backend.wxnotice.update',
    'uses' => 'WxNoticeController@update',
]);
Route::post('sendnotice', [

    'uses' => 'WxNoticeController@send',
]);

Route::post('deletemulit', [

    'uses' => 'MessageController@deletemulit',
]);

///* 微信模板列表 */
Route::get('templatelist', [
    'as' => 'backend.wxtemplatelist.index',
    'uses' => 'WxTemplateController@index',
]);
Route::get('template/{id}/show', [
    'as' => 'backend.template.show',
    'uses' => 'WxTemplateController@show',
]);
Route::get('synchronizeTemplate', [
    'as' => 'backend.template.synchronize',
    'uses' => 'WxTemplateController@synchronize',
]);
///* 微信模板消息 */
Route::get('templatemessage', [
    'as' => 'backend.wxtemplatemessage.index',
    'uses' => 'WxTemplateMessageController@index',
]);
Route::get('templatemessage/{id}/show', [
    'as' => 'backend.wxtemplatemessage.show',
    'uses' => 'WxTemplateMessageController@show',
]);
//微信菜单
Route::get('synchronizeMenu', [
    'as' => 'backend.wxmenu.synchronize',
    'uses' => 'WxMenuController@synchronize',
]);
Route::get('menu', [
    'as' => 'backend.wxmenu.index',
    'uses' => 'WxMenuController@index',
]);
Route::get('menu/create', [
    'as' => 'backend.wxmenu.create',
    'uses' => 'WxMenuController@create',
]);
Route::post('menu/store', [
    'as' => 'backend.wxmenu.store',
    'uses' => 'WxMenuController@store',
]);
Route::delete('menu/{id}/destory', [
    'as' => 'backend.wxmenu.destory',
    'uses' => 'WxMenuController@destory',
]);

Route::get('menu/{id}/edit', [
    'as' => 'backend.wxmenu.edit',
    'uses' => 'WxMenuController@edit',
]);
Route::post('updateWxMenu/{id}', [
    'as' => 'backend.wxmenu.update',
    'uses' => 'WxMenuController@update',
]);


