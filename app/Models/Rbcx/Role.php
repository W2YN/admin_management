<?php
/**
 * Role.php
 * Date: 2017/1/5
 */

namespace App\Models\Rbcx;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'mysql_rbcx';

    protected $table = 'role';

    protected $guarded = [];

    public $timestamps = false;
}