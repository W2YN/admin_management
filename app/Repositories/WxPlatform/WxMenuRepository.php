<?php

namespace App\Repositories\WxPlatform;

use App\Facades\HelpFacades;

use App\Http\Requests\Form\WxPlatform\WxMenuRequest;
use App\Repositories\CommonRepository;


class WxMenuRepository extends CommonRepository
{
    public static $accessor = 'wxmenu_repository';

    /**
     *
     * @return WxMenuRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor(self::$accessor);
    }

    public function OrderByLevel()
    {
        return $this->model->orderBy('level_id', 'ASC')->paginate(20);
    }

//    在index中显示菜单的上级菜单
    public function showBelong($level_id)
    {
        $name = $this->model->where('id', $level_id)->pluck('name');
        return $name;
    }

    //    在index中显示菜单的上级菜单
    public function showOrder($id)
    {
        $menu = $this->model->where('id', $id)->first();
        $level_id = $menu->level_id;

        if ($menu->level == 1) {
            $topmenus = $this->model->where('level', 1)->lists('id')->toArray();
            foreach ($topmenus as $key => $value) {
                if ($value == $id) {
                    return  '顶级菜单'.'(' . ($key + 1) . ')' ;
                }
            }

        } else {
            $submenus = $this->model->where('level_id', $level_id)->lists('id')->toArray();

            $name = $this->model->where('id', $menu->level_id)->pluck('name');
            foreach ($submenus as $key => $value) {
                if ($value == $id) {
                    return $name.'(' . ($key + 1) . ')' ;
                }
            }


        }

    }

    public function createMenu(WxMenuRequest $request)
    {
        $level_id = $request->get('level_id');
        $this->checkMenu($level_id);
        $model = $this->model;
        if ($level_id == '0') {
            $data['level'] = 1;
        } else {
            $data['level'] = 2;
        }
        $res = $model::create(array_merge($request->all(), $data));
        return $res;
    }

//    更新菜单
    public function updateMenu(WxMenuRequest $request, $id)
    {
        $level_id = $request->get('level_id');
        $model = $this->model;
        $menu = $model::find($id);
        //顶级菜单修改所属 ........................
        if ($menu->level_id != $level_id) {
            $this->checkMenu($level_id);
            $count = $model::where('level_id', $id)->count();
            if ($menu->level == 1 && $count > 0) {
                throw new \Exception("变更顶级菜单,请先删除该顶级菜单的二级菜单");
            }
        }
        if ($level_id == '0') {
            $data['level'] = 1;
        } else {
            $data['level'] = 2;
        }
        $res = $menu->update(array_merge($request->all(), $data));
        return $res;
    }

//删除菜单
    public function destoryMenu($id)
    {
        $model = $this->model;
        $count = $model::where('level_id', $id)->count();
        $menu = $model::where('id', $id)->first();
        if ($menu->level == 1 && $count > 0) {
            throw new \Exception("请先删除该顶级菜单的二级菜单");
        } else {
            $res = $menu->delete();
        }
        return $menu;
    }

//    得到一级菜单列表
    public function getLevelMenu()
    {
        $model = $this->model;
        $res = $model::where('level', 1)->get();
        return $res;
    }

//检查一级菜单和二级菜单的数量
    public function checkMenu($level_id)
    {
        $model = $this->model;
        $topMenu = $model::where('level', 1)->get();
        $belongMenu = $model::where('level_id', $level_id)->get();
        if (count($topMenu) >= 3 && $level_id == 0) {
            throw new \Exception("一级菜单数量不能超过3个");
        }
        if (count($belongMenu) >= 5) {
            throw new \Exception("二级菜单数量不能超过5个");
        }
    }

//更新菜单
    public function synchronize()
    {
        $url = config('wechat.synchronize.menu');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        \Log::info('菜单更新' . $output);
        if ($output) {
            $result = json_decode($output, true);
            if ($result['erro']) {
                $result = json_encode(['result' => $result['erro']]);
                return $result;
            }
            $result = json_encode(['result' => 'ok']);
            return $result;
        }
        $result = json_encode(['result' => 'fail']);
        return $result;
    }
}
