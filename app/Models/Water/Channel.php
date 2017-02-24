<?php

namespace App\Models\Water;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
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
	protected $table = "channels";
	
	protected $dates = ['deleted_at'];
}
