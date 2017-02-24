<?php

namespace App\Models\Water;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installment extends Model
{
	use SoftDeletes;
	
    protected $connection = 'mysql_water_purifier';

    protected $table = "installments";
    /**
     * [$guarded description]
     *
     * @var array
     */
    protected $guarded = [];
	
    protected $dates = ['deleted_at'];

    public function order()
    {
        return $this->hasOne('App\Models\Water\Purifier','id','water_purifier_id');
    }
}
