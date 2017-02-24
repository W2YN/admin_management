<?php
/**
 * Log.php
 * Date: 2016/10/20
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActionLogger extends Model
{
    use SoftDeletes;

    protected $table = "operation_logs";

    protected $guarded = [];
}