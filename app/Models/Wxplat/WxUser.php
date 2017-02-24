<?php

namespace App\Models\Wxplat;

use Illuminate\Database\Eloquent\Model;

class WxUser extends Model
{
    protected $connection = 'mysql_wx_official_accounts';
    //
    protected $fillable=['openid','nickname','sex','city','province','subscribe_time'];
}
