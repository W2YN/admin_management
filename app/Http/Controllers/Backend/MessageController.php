<?php
/**
 * MessageController.php
 * Date: 2016/10/24
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Repositories\MessageRepository;

class MessageController extends Controller
{
    /**
     * @var array
     */
    private $user;
    public function __construct()
    {
        $this->middleware("search", ['only'=>['index']]);
        $this->user = \Auth::user();
        //var_dump($this->user);exit;
    }

    /**
     * 消息首页的加载
     * @warning 什么，没模板用了，岂有此理?
     */
    public function index(Request $request)
    {
        $where = $request->get('where') ?: [];
        array_push($where, ['to', '=', $this->user['id']]);
        array_push($where, ['to_name', '=', $this->user['name']]);
        $data = MessageRepository::getInstance()->receive($where);

        //$data = MessageRepository::getInstance()->paginateWhere()

        return view('backend.message.index', compact("data"));
    }

    /**
     * 设置消息为已读
     * @param Request $request
     */
    public function read(Request $request)
    {
        if(MessageRepository::getInstance()->read($request->get('id'))) return 1;//已读
        else return 0; //未读
    }

    //是否有未读的消息
    public function ask()
    {
        return MessageRepository::getInstance()->noReadCount();
    }

    public function readAll()
    {
        Message::where('to', \Auth::user()->id)->update(['is_read'=>1]);
        return 1;
    }
}