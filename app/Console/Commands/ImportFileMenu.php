<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Menu;
use DB;

class ImportFileMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将文件中的菜单内容导入到数据库中';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $menus = config('fileMenu');
        $sysCategory = env('CATEGORY');
        if(file_exists('tmp.json')){
            $content = file_get_contents('tmp.json');
            if($content) {
                $migrateArr = json_decode($content, true);
                $menus = array_merge($menus, $migrateArr);
            }
        }
        //$migrateArr = json_decode(file_get_contents('tmp.json'), true);
        $menuArr = [];
        $updateArr = [];

        foreach($menus as $menu) {
            /*if($sysCategory != $menu['env']) { //这个暂且注释了
                continue;
            }*/

            //获取父菜单,从逻辑及操作上来说，这必须是父菜单
            $DBMenu = Menu::where('route', $menu['route'])->first();
            $parentId = 0;
            if($DBMenu) { //如果存在,更新
                $parentId = $DBMenu->id;
                $DBMenu->name = $menu['name'];
                $DBMenu->description = isset($menu['description'])? $menu['description']: $menu['name'];
                $DBMenu->sort = isset($menu['sort']) ? $menu['sort']: 0;
                $DBMenu->hide = isset($menu['hide']) ? $menu['hide']: 0;
                $DBMenu->save(); //这里需要实时更新
                //array_push($updateArr, $DBMenu);
            } else { //创建父菜单
                $parentId = $this->store($menu);
                if(!$parentId) {
                    exit("error on create parent:". $menu['name']);
                }
            }
            foreach($menu['children'] as $child) {
                /*
                 if($child['route'] == $menu['route']) { //如果子菜单route和夫菜单相同，尝试获取第二个，从数据库中
                    continue;
                } else { //尝试获取第一个，从数据库中

                }*/
                $dbMenus = Menu::where('route', $child['route'])->get();
                $subDBMenu = false;
                foreach($dbMenus as $_menu) {
                    if($_menu['name'] != $menu['name'] and $_menu['parent_id'] == $parentId) { //判断条件之一
                        $subDBMenu = $_menu;
                        break;
                    }
                }
                //if(!$subDBMenu) {
                  //  exit("can't find route:". $child['route']);
                //}
                //$subDBMenu = Menu::where('route', $child['route'])->first();
                if(!$subDBMenu) { //不存在,创建
                    $child['parent_id'] = $parentId;
                    $child['description'] = $child['name'];
                    $child['created_at'] = time();
                    $child['updated_at'] = time();
                    //$this->store($child);
                    array_push($menuArr, $child);
                } else { //存在就更新
                   // echo "update ".$child['route']." name:" . $child['name']. "\n";
                        $subDBMenu->name = $child['name'];
                        $subDBMenu->description = isset($child['description'])? $child['description']: $child['name'];
                        $subDBMenu->sort = $child['sort'];
                        $subDBMenu->hide = $child['hide'];
                        //$subDBMenu->save();
                    array_push($updateArr, $subDBMenu);
                    //$dbMenu->save();
                }
            }
        }

        try{
            DB::beginTransaction();
            foreach($menuArr as $menu){
                $this->store($menu);
            }
            foreach($updateArr as $menu){
                $menu->save();
            }
            DB::commit();
            echo "******** Import Success ! *************\n";
        }catch(\Exception $e){
            DB::rollBack();
            echo "ERROR:".$e->getMessage()."\n";
        }
        return true;
    }

    private function store($menu)
    {
        $newMenu = new Menu;
        $newMenu-> parent_id = isset($menu['parent_id']) ? $menu['parent_id']: 0;
        $newMenu->icon = isset($menu['icon'])? $menu['icon']: '';
        $newMenu->name = $menu['name'];
        $newMenu->route = $menu['route'];
        $newMenu->description = $menu['name'];
        //$newMenu->description = $menu['name'];
        $newMenu->sort = isset($menu['sort']) ? $menu['sort']: 0; //
        $newMenu->hide = isset($menu['hide']) ? $menu['hide']: 0; //
        $newMenu->created_at = time();
        $newMenu->updated_at = time();
        $newMenu->save();
        return $newMenu->id;
    }
}
