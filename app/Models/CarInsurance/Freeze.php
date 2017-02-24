<?php
/**
 * Freeze.php
 * Date: 2016/12/1
 */

namespace App\Models\CarInsurance;

use Illuminate\Database\Eloquent\Model;

class Freeze extends  Model
{
    //
    protected $connection = 'mysql_car_insurance';

    protected $table = "freeze";
    /**
     * [$guarded description]
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @param $params array
     */
    public function store($params)
    {
        //$freeze = new Freeze;//()
        foreach($params as $key=>$value){
            $this->$key = $value;
        }
        return $this->save();
        //return $this;
    }
    /**
     * 取消冻结，为了生成新的冻结准备
     */
    public function clear()
    {
        $this->datetime = date('Y-m-d H:i:s');
        $this->freeze_queryid = '';
        $this->money = 0;
        $this->save();
    }
}