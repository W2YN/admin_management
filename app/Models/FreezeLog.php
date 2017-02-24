<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreezeLog extends Model
{
    public function __construct(array $attributes = [])
    {
        $this->table = config('ourplus.rbcx-database') . '.freeze_log';
        parent::__construct($attributes);
    }

    /**
     * [$guarded description]
     *
     * @var array
     */
    protected $guarded = [];

    public function order()
    {
        return $this->hasOne('App\Models\Order','id','order_id');
    }
}
