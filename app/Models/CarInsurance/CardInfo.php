<?php

namespace App\Models\CarInsurance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardInfo extends Model
{
    use SoftDeletes;
    //
    protected $connection = 'mysql_car_insurance';

     protected $table = "card_info";
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



}
