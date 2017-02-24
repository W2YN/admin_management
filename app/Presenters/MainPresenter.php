<?php

namespace App\Presenters;

use App\Facades\UserRepository;
use Auth;
use Cache;
use Route;

/**
 * Menu View Presenters
 */
class MainPresenter extends CommonPresenter
{
    /**
     * 左侧栏视图缓存键
     */
    const SIDEBAR_MENUS_CACHE = 'sidebar_menus_view_cache';

    /**
     * 面包屑导航缓存键
     */
    const BREADCRUMBS_MENUS_CACHE = 'breadcrumbs_menus_view_cache:';

    /**
     * 渲染左侧栏视图
     *
     * @param  array $route
     * @param  array $menus
     *
     * @return mixed
     */
    public function renderSidebar(array $menus, $route)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->to('/auth/logout');
        }

        $routes = UserRepository::getUserMenusPermissionsByUserModel($user);

        if (!$routes) {
            return "";
        }

        if ($user['is_super_admin'] == 0) {
            foreach ($menus as $key => $menu) {
                if (!in_array($menu['route'], $routes)) {
                    unset($menus[$key]);
                }
            }
        }

        $trees = create_node_tree($menus);
        $array = self::buildBreadcrumbsArray($menus, $route);
        $active = array_map(function ($value) {
            return $value['route'];
        }, $array);

        /* 生成左侧栏 HTML */
        $sidebar = '';
        //$sidebar = '<ul class="sidebar-menu">';
        $sidebar .= self::makeSidebar($trees, $active);
        //$sidebar .= '</ul>';
        //echo $sidebar;print_r($trees);exit;
        return $sidebar;
    }


    /**
     * 生成面包屑数组
     *
     * @param array $menus
     * @param string $route
     * @param int $parent_id
     *
     * @return array
     */
    protected static function buildBreadcrumbsArray(array $menus, $route = '', $parent_id = 0)
    {
        $breadcrumbs = [];
        foreach ($menus as $key => $value) {
            if ($route) {
                if ($value['route'] == $route) {
                    $breadcrumbs[] = $value;
                    $breadcrumbs = array_merge($breadcrumbs,
                        self::buildBreadcrumbsArray($menus, '', $value['parent_id']));
                }
            } else {
                if ($value['id'] == $parent_id) {
                    $breadcrumbs[] = $value;
                    $breadcrumbs = array_merge($breadcrumbs,
                        self::buildBreadcrumbsArray($menus, '', $value['parent_id']));
                }
            }
        }

        return $breadcrumbs;
    }


    /**
     * 生成左侧栏
     *
     * @param array $menus
     * @param array $active
     *
     * @return string
     */
    protected static function makeSidebar(array $menus, $active)
    {
        $sidebar = "";


        foreach ($menus as $menu) {
            $defulatSelect = $defulatShow = '';
            if ($menu == reset($menus)) {
                $defulatSelect = 'selected';
                $defulatShow = 'display: block;';
            }

            if ($menu['hide'] == 0) {
                $menuString = '';
                foreach ($menu['child'] as $child) {
                    if (Route::has($child['route'])) {
                        $href = route($child['route']);
                    } else {
                        $href = "javascript:void(0);";
                    }
                    $menuString .= "<li><a _href=\"" . $href . "\" data-title=\"" . $child['description'] . "\" href=\"javascript:void(0)\">" . $child['description'] . "</a></li>" . PHP_EOL;
                }
                $sidebar .= <<<EOT
        <dl id="{$menu['name']}">
            <dt class="{$defulatSelect}"><i class="Hui-iconfont">&#xe62e;</i> {$menu['description']}<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd style="{$defulatShow}">
                <ul>
                    $menuString
                </ul>
            </dd>
        </dl>
EOT;
            }
        }
        return $sidebar;
    }
//    protected static function makeSidebar(array $menus, $active)
//    {
//        $sidebar = "";
//
//        foreach ($menus as $menu) {
//            if ($menu['hide'] == 0) {
//                if ($menu['child']) {
//                    if (in_array($menu['route'], $active)) {
//                        $sidebar .= '<li class="treeview active">';
//                    } else {
//                        $sidebar .= '<li class="treeview">';
//                    }
//                    $sidebar .= '<a href="javascript:void(0);">
//                                    <i class="' . $menu['icon'] . '"></i>
//                                    <span>' . trans($menu['name']) . '</span>
//                                    <i class="fa fa-angle-left pull-right"></i>
//                                </a>
//                            <ul class="treeview-menu">' .
//                        self::makeSidebar($menu['child'], $active) . '
//                            </ul>
//                        </li>';
//                } else {
//                    if (in_array($menu['route'], $active)) {
//                        $sidebar .= '<li class="active">';
//                    } else {
//                        $sidebar .= '<li>';
//                    }
//
//                    if (Route::has($menu['route'])) {
//                        $sidebar .= '<a href="' . route($menu['route']) . '">';
//                    } else {
//                        $sidebar .= '<a href="javascript:void(0);">';
//                    }
//                    $sidebar .= '<i class="' . $menu['icon'] . '"></i>
//                                <span> ' . trans($menu['name']) . '</span>
//                            </a>
//                        </li>';
//                }
//            }
//        }
//
//        return $sidebar;
//    }

    /**
     * 渲染面包屑导航条视图
     *
     * @param  array $menus
     * @param  string $route
     *
     * @return mixed
     */
    public function renderBreadcrumbs(array $menus, $route)
    {
        $breadcrumbs = Cache::get(self::BREADCRUMBS_MENUS_CACHE . $route);
        if ($breadcrumbs) {
            return $breadcrumbs;
        } else {
            $array = self::buildBreadcrumbsArray($menus, $route);
            $breadcrumbs = self::makeBreadcrumbs($array);
            Cache::forever(self::BREADCRUMBS_MENUS_CACHE . $route, $breadcrumbs);

            return $breadcrumbs;
        }
    }

    /**
     * 渲染面包屑导航条视图
     *
     * @param  array $menus
     * @param  string $route
     *
     * @return mixed
     */
    public function renderBreadcrumbsV2(array $menus, $route)
    {
        $breadcrumbs = Cache::get(self::BREADCRUMBS_MENUS_CACHE . $route);
        if ($breadcrumbs) {
            return $breadcrumbs;
        } else {
            $array = self::buildBreadcrumbsArray($menus, $route);
            $breadcrumbs = self::makeBreadcrumbsV2($array);
            Cache::forever(self::BREADCRUMBS_MENUS_CACHE . $route, $breadcrumbs);

            return $breadcrumbs;
        }
    }

    /**
     * 生成面包屑
     *
     * @param array $array
     *
     * @return string
     */
    protected static function makeBreadcrumbs(array $array)
    {
        $array = two_dimensional_array_sort($array, 'sort', SORT_ASC);
        $breadcrumbs = '<ol class="breadcrumb">';
        foreach ($array as $key => $value) {

            if (count($array) == $key + 1) {
                $breadcrumbs .= '<li class="active">';
            } else {
                $breadcrumbs .= '<li>';
            }

            if ($value['route']) {
                if (Route::has($value['route'])) {
                    $breadcrumbs .= '<a href="' . route($value['route']) . '">';
                } else {
                    $breadcrumbs .= '<a href="#">';
                }
            } else {
                $breadcrumbs .= '<a href="#">';
            }

            if ($value['icon']) {
                $breadcrumbs .= '<i class="fa ' . trans($value['icon']) . '"></i> ';
            }
            $breadcrumbs .= trans($value['name']);
            $breadcrumbs .= '</a>';
            $breadcrumbs .= '</li>';
        }
        $breadcrumbs .= '</ol>';

        return $breadcrumbs;
    }

    /**
     * 生成面包屑
     *
     * @param array $array
     *
     * @return string
     */
    protected static function makeBreadcrumbsV2(array $array)
    {
        $array = two_dimensional_array_sort($array, 'sort', SORT_ASC);
        $breadcrumbs = '';
        foreach ($array as $key => $value) {
            //暂时使用描述代替名字，不使用语言包
            $breadcrumbs .= '<span class="c-gray en">&gt;</span> ' . $value['description'];
        }

        return $breadcrumbs;
    }
}
