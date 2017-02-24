<?php

namespace App\Models\Wxplat;

use Illuminate\Database\Eloquent\Model;

class WxNotice extends Model
{
    protected $connection = 'mysql_wx_official_accounts';
    //
    protected $guarded = ['filename','file'];
}
