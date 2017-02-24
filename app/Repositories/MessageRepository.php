<?php
/**
 * MessageRepository.php
 * Date: 2016/10/20
 */

namespace App\Repositories;

use App\Facades\HelpFacades;
use App\Repositories\CommonRepository;
use App\Models\Message;
use DB;

class MessageRepository extends CommonRepository
{
    public static $accessor = 'messages_repository';

    /**
     * @return MessageRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor(self::$accessor);
    }

    /**
     * 发送消息
     * @param $from
     * @param $to
     * @param $message
     * @return \stdClass
     */
    public function send($from, $to, $message)
    {
        $message = $this->create([
            "from" => $from,
            'to' => $to,
            'content'=>$message,
            'is_read' => 0,
            'is_delete'=>0
        ]);
        return $message;
    }

    /**
     * 接受消息
     * @param $where
     * @return mixed
     */
    public function receive($where)
    {
        //$where = [];

        //if($yourId) array_push($where, ['to', '=', $yourId]);
        //if($toName) array_push($where, ['to_name', '=', $toName]);
        $this->model = $this->model->orderBy('created_at', 'desc');
        return $this->paginateWhere($where, config('repository.page-limit'));
    }

    /**
     * 设置消息为已读
     * @param $id int
     */
    public function read($id)
    {
        //DB::query("update message set is_read=1 where id= ?",[$id]);
        $msg = Message::find($id);
        $msg->is_read = 1;
        return $msg->save();
    }

    /**
     * 按条件删除
     * @param $where array   比如, [['from','=',12], ['to','=','13]]
     */
    public function deleteByWhere($where)
    {
        $lists = $this->getByWhere($where);
        $to_delete = [];
        foreach($lists as $item){
            array_push($to_delete, $item->id);
        }
        return $this->destroy($to_delete);
        //return \DB::connection("mysql_car_insurance")->update("update message set is_delete=1 where from=?", [$fromId]);
    }

    /**
     * 通过id删除消息,id可为integer或者integer数组
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->destroy($id);
    }

    public function noReadCount()
    {
        return Message::where('is_read', 0)->where('to',\Auth::user()->id)->count();
    }
}