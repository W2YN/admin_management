<?php

namespace App\Models\Wxplat;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $connection = 'mysql_wx_official_accounts';

    protected $table = 'wx_events';
    /**
     * [$guarded description]
     *
     * @var array
     */
    protected $guarded = ['filename','file'];

    /**
     *  应被转换为日期的属性。
     *
     * @var array
     */



}
