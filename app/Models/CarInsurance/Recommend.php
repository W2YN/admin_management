<?php
/**
 * Recommend.php
 * Date: 2016/12/6
 */

namespace App\Models\CarInsurance;

use Illuminate\Database\Eloquent\Model;

class Recommend extends Model
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



}