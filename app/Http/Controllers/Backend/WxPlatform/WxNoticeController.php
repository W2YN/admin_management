<?php

namespace App\Http\Controllers\Backend\WxPlatform;




use App\Repositories\WxPlatform\WxNoticeRepository;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class WxNoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    

        $where = $request->get('where');
        $data = WxNoticeRepository::getInstance()->paginateWhere($where, config('repository.page-limit'));

        return view('backend.wxplatform.notice.index', compact('data'));
    }
    public function create()
    {
        return view('backend.wxplatform.notice.create');
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
            if (WxNoticeRepository::getInstance()->createWithImage($request)) {

                return $this->successRoutTo('backend.wxnotice.index', "新增菜单成功");
            }
        } catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
        //
    }

    public function edit($id)
    {
      
        $notice = WxNoticeRepository::getInstance()->find($id);

        return view('backend.wxplatform.notice.edit', compact('notice'));
        //
    }
    public function update(Request $request, $id)
    {

        try {

            WxNoticeRepository::getInstance()->updateNotice($id,$request);
      
            return back()->with('success', '修改成功');

        } catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }


    }
    public function send(Request $request)
    {

       dd('A');

    }

}
