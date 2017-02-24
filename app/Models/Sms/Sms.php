<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    //protected $connection = 'mysql_water_purifier';

    protected $table = "smss";
    /**
     * [$guarded description]
     *
     * @var array
     */
    protected $guarded = [];
}
