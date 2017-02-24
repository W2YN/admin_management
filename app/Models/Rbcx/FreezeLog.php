<?php
/**
 * FreezeLog.php
 * Date: 2017/1/4
 */

namespace App\Models\Rbcx;

use Illuminate\Database\Eloquent\Model;

class FreezeLog extends Model
{
    protected $connection = 'mysql_rbcx';

    protected $table = 'freeze_log';

    protected $guarded = [];

    public $timestamps = false;

    //protected $dates = ['processDate'];

    /**
     * 存储该日志
     * @param $params
     */
    public static function store($params)
    {
        $log = new FreezeLog();
        foreach($params as $key=>$value){
            switch ($key){
                case "order_num":
                    $key = "order_no";
                    break;
                case "freeze_time":
                    $key = 'datetime';
                    break;
                case "freeze_money":
                    $key = "money";
                    break;
                case "freeze_queryId":
                    $key = "freeze_queryid";
                    break;
                case "status":
                    $key = "type";
                    break;
                case "orderNum":
                    $key = "orderNo";
                    break;
                case "processTime":
                    $key = "processDate";
                    break;
            }
            $log->$key = $value;
        }
        return $log->save();
    }
}