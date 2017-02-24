<?php
/**
 * Policy.php
 * Date: 2016/11/21
 */

namespace App\Models\CarInsurance;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $connection = 'mysql_car_insurance';

    protected $guarded = [];

    protected $table = 'policy';

    /**
     * 根据$orderId生成一个默认的policy
     * @param $orderId
     */
    public static function createDefaultPolicy($orderId)
    {
        $p = new Policy();
        $p->compulsory_insurance = 1;
        $p->order_id = $orderId;
        $p->save();
    }
}