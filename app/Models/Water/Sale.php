<?php

namespace App\Models\Water;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $connection = 'mysql_water_purifier';

    protected $table = "sales";
    /**
     * [$guarded description]
     *
     * @var array
     */
    protected $guarded = [];
}
