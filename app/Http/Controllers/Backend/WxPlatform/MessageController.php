<?php

namespace App\Http\Controllers\Backend\WxPlatform;


use App\Models\Wxplat\WxMultiMessage;
use App\Repositories\WxPlatform\WxMessageRepository;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $where = $request->get('where');
        $data = WxMessageRepository::getInstance()->paginateWhere($where, config('repository.page-limit'));
        return view('backend.wxplatform.message.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.wxplatform.message.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if (WxMessageRepository::getInstance()->createWithImage($request)) {

                return $this->successRoutTo('backend.wxmessage.index', "新增菜单成功");
            }
        } catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $message = WxMessageRepository::getInstance()->find($id);
        return view('backend.wxplatform.message.edit', compact('message'));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            WxMessageRepository::getInstance()->updateMessage($id, $request);
            return back()->with('success', '修改成功');

        } catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }


    }

    public function destory($id)
    {
        try {
            if (WxMessageRepository::getInstance()->destroy($id)) {

                return '删除成功';
            }
        } catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }


    public function deletemulit(Request $request)
    {
        WxMultiMessage::where('id', $request->get('mulitId'))->delete();
        return 'ok';
    }

}
