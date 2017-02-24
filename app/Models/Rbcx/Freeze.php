<?php
/**
 * Freeze.php
 * Date: 2017/1/5
 */

namespace App\Models\Rbcx;

use Illuminate\Database\Eloquent\Model;

class Freeze extends Model
{
    protected $connection = 'mysql_rbcx';

    protected $table = 'freeze';

    protected $guarded = [];

    public $timestamps = false;


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


    /**
     * 重复的创建冻结
     */
    //public static function createFreeze()
    //{

    //}
    public function store($params)
    {
        //$freeze = new Freeze;//()
        foreach($params as $key=>$value){
            $this->$key = $value;
        }
        return $this->save();
        //return $this;

    }
}