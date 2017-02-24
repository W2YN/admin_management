<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Menu;

class ExportMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '导出菜单列表,结构与配置一致';

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
     */
    public function handle()
    {
        //
        $resultArr = [];
        $menus = Menu::where('parent_id', 0)->get();
        foreach($menus as $menu){
            $tmp = $menu->toArray();
            unset($tmp['id'], $tmp['parent_id']);//unset($tmp['parent_id']);
            //unset($tmp, "parent_id");
            $tmp['env'] = env('CATEGORY');
            $tmp['children'] = [];
            $children = Menu::where('parent_id', $menu['id'])->get();
            foreach($children as $child) {
                $childArr = $child->toArray();
                unset($childArr['id'], $childArr['parent_id']);//unset($childArr['parent_id']);
                array_push($tmp['children'], $childArr);
                //array_push($menu->children, $child);
            }
            array_push($resultArr, $tmp);
            //array_push($menu->children, $)
        }
        $jsonArr = json_encode($resultArr);
        file_put_contents("tmp.json", $jsonArr);
        echo "********* export data to tmp.json success ! *************************\n";
        //exit($jsonArr);
       // return true;
    }
}
