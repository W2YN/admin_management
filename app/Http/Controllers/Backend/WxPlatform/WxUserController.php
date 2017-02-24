<?php

namespace App\Http\Controllers\Backend\WxPlatform;




use App\Repositories\WxPlatform\WxUserRepository;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class WxUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    

        $where = $request->get('where');
        $data = WxUserRepository::getInstance()->paginateWhere($where, config('repository.page-limit'));

        return view('backend.wxplatform.user.index', compact('data'));
    }



 
}
