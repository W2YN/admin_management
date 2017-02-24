<?php

namespace App\Models\Rbcx;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{

    protected $connection = 'mysql_rbcx';

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
    protected $table = "installment";

    public $timestamps = false;


    public function order()
    {
        return $this->hasOne('App\Models\Rbcx\Order','id','order_id');
    }

    /**
     * @deprecated
     */
    public function makeDone()
    {
        $this->debit_money = $this->money;
        $this->status = 2;
        $this->save();
    }

    /**
     * 使之变更为已扣过款状态
     */
    public function makeCharged()
    {
        $id = $this->id;
        $orderId = $this->order->id;
        if($this->debit_money != $this->money) { //说明还有未扣款，错误
            throw new \Exception("异常:在设置订单{{$orderId}}的分期{{$id}}为已扣款状态时，发现本期金额还有剩余! ");
        }
        $this->status = 2; //设置标志位
        return $this->save();
    }
    /**
     * 扣除money
     * @param $chargeMoney
     */
    public function charge($chargeMoney)
    {
        $this->debit_money += $chargeMoney;
        $this->save();
    }

    public function changeStatus( $i ){
        $this->status = $i;
        $this->save();
    }
}
