<?php
/**
 * Message.php
 * Date: 2016/10/20
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
   // protected $connection = "mysql_car_insurance";

    protected $table = "messages";

    protected $guarded = [];

    protected $dates = ['deleted_at'];
}