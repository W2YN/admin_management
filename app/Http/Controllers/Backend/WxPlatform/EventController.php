<?php

namespace App\Http\Controllers\Backend\WxPlatform;


use App\Repositories\WxPlatform\WxEventRepository;


use App\Services\LogService;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = $request->get('where');
        $data = WxEventRepository::getInstance()->paginateWhere($where, config('repository.page-limit'));
        return view('backend.wxplatform.event.index', compact('data'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = WxEventRepository::getInstance()->find($id);
        return view('backend.wxplatform.event.edit', compact('event'));
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
            WxEventRepository::getInstance()->updateMessage($id, $request);
            return back()->with('success', '修改成功');

        } catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }


    }


    public function picture(Request $request)
    {
        $save_path = WxEventRepository::getInstance()->storePicture($request);

        if ($save_path) {
            return $this->responseJson([
                'success' => true,
                'avatar' => $save_path,
            ]);
        } else {
            return $this->responseJson([
                'success' => false,
            ]);
        }


    }

}
