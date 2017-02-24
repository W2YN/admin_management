<?php

namespace App\Http\Controllers\Backend\WxPlatform;


use App\Repositories\WxPlatform\WxTemplateMessageRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WxTemplateMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('search', ['only' => [ 'index']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $where = $request->get('where');
        $data = WxTemplateMessageRepository::getInstance()->paginateWhere($where, config('repository.page-limit'));

        return view('backend.wxplatform.templatemessage.index', compact('data'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = WxTemplateMessageRepository::getInstance()->find($id);
        return view('backend.wxplatform.templatemessage.show', compact('data'));


    }


}
