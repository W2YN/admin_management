<?php

namespace App\Models\Water;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
	use SoftDeletes;
	
    protected $connection = 'mysql_water_purifier';
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
    protected $table = "devices";
	
    protected $dates = ['deleted_at'];
    
    public function maintains()
    {
        return $this->hasMany('App\Models\Water\Maintain');
    }
}
