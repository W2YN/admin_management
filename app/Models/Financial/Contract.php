<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
	use SoftDeletes;
	
	protected $connection = 'mysql_financial';
	
	protected $table = 'financial_contract';
	
	/**
	 * 需要被转换成日期的属性。
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];

	/**
	 * 从属于一条快递
	 */
	public function express()
	{
		return $this->belongsTo('App\Models\Financial\Express');
	}
	
	/**
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\Financial\User', 'financial_user_id');
	}
	
}
