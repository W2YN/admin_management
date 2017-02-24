<?php

namespace App\Http\Controllers\Backend\WxPlatform;


use App\Repositories\WxPlatform\WxTemplateRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WxTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $where = $request->get('where');
        if (is_array($where)) {
            array_push($where, ['status', '=', 1]);
        } else {
            $where[] = ['status', '=', 1];
        }
        $data = WxTemplateRepository::getInstance()->paginateWhere($where, config('repository.page-limit'));

        return view('backend.wxplatform.template.index', compact('data'));
    }

    public function show($id)
    {
        $data = WxTemplateRepository::getInstance()->find($id);
        return view('backend.wxplatform.template.show', compact('data'));
    }

    public function synchronize()
    {
        $res = WxTemplateRepository::getInstance()->synchronize();
        return $res;
    }

}
