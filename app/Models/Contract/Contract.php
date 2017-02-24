<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{

    use SoftDeletes;

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
    protected $table = "contracts";

    public function installments()
    {
        return $this->hasMany('App\Models\Contract\ContractInstallment', 'contract_id');
    }
}
