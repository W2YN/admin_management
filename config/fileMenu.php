<?php
/**
 * fileMenu.php
 * Date: 2016/11/18
 */
//category prod | dev
return [
    /*["name" => '菜单管理', 'route' => 'backend.menu', 'env' => 'dev',
        'children' => [
            ['name' => '菜单独一无二', 'route' => 'backend.menu.unique', 'sort'=>1, 'hide'=>0], //2
        ]
    ],*/
    /*['name'=>'自我测试', 'route' => 'backend._test', 'env' => 'dev',
        'children' => [
            ['name' => '孩子1', 'route'=>'backend._test.sonOne', 'sort'=>1, 'hide'=>0],
            ['name' => '孩子2', 'route'=>'backend._test.sonTwo', 'sort'=>2, 'hide'=>0],
            ['name' => '孩子3', 'route'=>'backend._test.sonThree', 'sort'=>3, 'hide'=>0],
            ['name' => '孩子3', 'route'=>'backend._test.sonFour', 'sort'=>4, 'hide'=>0],
        ]
    ],*/
    ['name'=>'系统管理', 'route'=> 'backend.system.index', 'env'=>'dev',
        'children' => [
            ['name' => '操作日志', 'route'=>'backend.actionLogger.index', 'sort'=>1,'hide'=>0]
        ]
    ]
];