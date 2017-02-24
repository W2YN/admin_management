<?php
/**
 * Created by PhpStorm.
 * User: HONDA
 * Date: 2016/10/11
 * Time: 10:06
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WxActivityStat extends Model
{
    protected $connection = 'mysql_wx_official_accounts';
    /**
     * 限制读取字段
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 设置模型表名
     *
     * @var string
     */
    protected $table = "wx_activity_stat";
}