<?php
/**
 * PaymentLog.php
 * Date: 2016/11/30
 */

namespace App\Models\CarInsurance;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $connection = 'mysql_car_insurance';

    protected $table='payment_logs';

    /**
     * [$guarded description]
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 存储一个支付日志情况
     */
    public static function store($params)
    {
        $log = new PaymentLog;
        foreach($params as $key=>$value){
            $log->$key = $value;
        }
        //$log->freeze_time = time();
        return $log->save();
    }

}