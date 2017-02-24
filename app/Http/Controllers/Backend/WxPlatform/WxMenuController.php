<?php

namespace App\Http\Controllers\Backend\WxPlatform;


use App\Http\Requests\Form\WxPlatform\WxMenuRequest;
use App\Repositories\WxPlatform\WxMenuRepository;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class WxMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $data = WxMenuRepository::getInstance()->OrderByLevel();

        return view('backend.wxplatform.menu.index', compact('data'));
    }

    public function create()
    {
        $levelmenus = WxMenuRepository::getInstance()->getLevelMenu();
        return view('backend.wxplatform.menu.create', compact('levelmenus'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(WxMenuRequest $request)
    {

        try {
            if (WxMenuRepository::getInstance()->createMenu($request)) {

                return $this->successRoutTo('backend.wxmenu.index', "新增菜单成功");
            }
        } catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
//        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $levelmenus = WxMenuRepository::getInstance()->getLevelMenu();
        $menu = WxMenuRepository::getInstance()->find($id);
        return view('backend.wxplatform.menu.edit', compact(['menu', 'levelmenus']));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(WxMenuRequest $request, $id)
    {

        try {

            WxMenuRepository::getInstance()->updateMenu($request, $id);
            return back()->with('success', '修改成功');

        } catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }


    }

    public function destory($id)
    {
        try {
            if (WxMenuRepository::getInstance()->destoryMenu($id)) {

                return '删除成功';
            }
        } catch (\Exception $e) {

            return response($e->getMessage(),404);

        }
    }


    public function synchronize()
    {
        $res = WxMenuRepository::getInstance()->synchronize();

        return $res;
    }


}
