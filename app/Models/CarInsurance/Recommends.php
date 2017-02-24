<?php

namespace App\Models\CarInsurance;

use Illuminate\Database\Eloquent\Model;

class Recommends extends Model
{
    //
    protected $connection = 'mysql_car_insurance';

    protected $table = "recommends";
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



}
