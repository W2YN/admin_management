<?php

namespace App\Models\Rbcx;

use Illuminate\Database\Eloquent\Model;

class CardInfo extends Model
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
    protected $table = "card_info";
    public function order()
    {
        return $this->belongsTo('App\Models\Rbcx\Order');
    }
}
