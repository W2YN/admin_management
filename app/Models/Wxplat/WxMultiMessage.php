<?php

namespace App\Models\Wxplat;

use Illuminate\Database\Eloquent\Model;

class WxMultiMessage extends Model
{
    protected $connection = 'mysql_wx_official_accounts';
    protected $guarded = ['filename','file'];
    public function message(){
        return $this->belongsTo(Message::class);
    }
    //
}
