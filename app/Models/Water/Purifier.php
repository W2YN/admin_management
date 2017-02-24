<?php

namespace App\Models\Water;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purifier extends Model
{
	use SoftDeletes;
	
    protected $connection = 'mysql_water_purifier';

    protected $table = "water_purifier";
    /**
     * [$guarded description]
     *
     * @var array
     */
    protected $guarded = [];
	
    protected $dates = ['deleted_at'];
    
    public function installments()
    {
        return $this->hasMany('App\Models\Water\Installment', 'water_purifier_id');
    }

    public function devices()
    {
        return $this->hasMany('App\Models\Water\Device', 'water_purifier_id');
    }

    public function cardInfo()
    {
        return $this->hasOne('App\Models\Water\BankCard', 'id', 'card_id');
    }
}
