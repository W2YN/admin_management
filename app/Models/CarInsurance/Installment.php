<?php

namespace App\Models\CarInsurance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installment extends Model
{
    use SoftDeletes;
    //
    protected $connection = 'mysql_car_insurance';

    protected $table = "installment";
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
    protected $dates = ['deleted_at'];


    public function getStatusAttribute($value)
    {
        $status = config('carInsurance.installmentStatus');
        if (isset($status[$value])) {
            return $status[$value];
        } else {
            return '未知';
        }

    }

    public function getTypeAttribute($value)
    {
        $status = config('carInsurance.insuranceType');
        if (isset($status[$value])) {
            return $status[$value];
        } else {
            return '未知';
        }

    }

    /**
     * 生成一个新的分期
     * @param array $arr
     */
    public static function store(array $arr)
    {
        $installment = new Installment;
        foreach($arr as $key=>$value){
            $installment->$key = $value;
        }
        return $installment->save();
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

    public function order()
    {
        return $this->hasOne('App\Models\CarInsurance\Order','id','order_id');
    }

    public function changeStatus( $i ){
        $this->status = $i;
        $this->save();
    }
}
