<?php

namespace App\Models\Wxplat;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $connection = 'mysql_wx_official_accounts';

    protected $table = 'wx_messages';
    /**
     * [$guarded description]
     *
     * @var array
     */
    protected $guarded = ['filename', 'file'];
    protected $fillable = ['message_name','type_id', 'return_id', 'mediaId', 'title', 'description', 'image', 'content_url', 'action'];
    /**
     *  应被转换为日期的属性。
     *
     * @var array
     */
    public function mulitmessage()
    {
        return $this->hasMany(WxMultiMessage::class);
    }


}
