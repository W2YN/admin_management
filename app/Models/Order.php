<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/10
 * Time: 16:53
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function __construct(array $attributes = [])
    {
        $this->table = config('ourplus.rbcx-database') . '.order';
        parent::__construct($attributes);
    }

    /**
     * [$guarded description]
     *
     * @var array
     */
    protected $guarded = [];

}