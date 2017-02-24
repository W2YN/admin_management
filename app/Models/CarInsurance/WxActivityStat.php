<?php

namespace App\Models\CarInsurance;

use Illuminate\Database\Eloquent\Model;

class WxActivityStat extends Model
{
    //
    protected $connection = 'mysql_wx_official_accounts';

     protected $table = "wx_activity_stat";
    /**
     * [$guarded description]
     *
     * @var array
     */
    protected $guarded = [];

    /**
     *  应被转换为日期的属性。
     *
     * @var array
     */



}
