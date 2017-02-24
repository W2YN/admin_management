<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Express extends Model
{
	use SoftDeletes;
	
	protected $connection = 'mysql_financial';
	
	protected $table = 'financial_express';
	
	/**
	 * 需要被转换成日期的属性。
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];
	
	protected $guarded = ['id'];
	
	/**
	 * 一快递对多合同
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function contract()
	{
		return $this->hasMany('App\Models\Financial\Contract');
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\Financial\User', 'financial_user_id');
	}
	
}
