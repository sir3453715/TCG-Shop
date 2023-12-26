<?php

return[

    // 角色
    'roles' => [
        ['name' => 'administrator', 'displayName' => '最高權限管理員'],
        ['name' => 'manager' , 'displayName' => '管理員'],
        ['name' => 'vendor' , 'displayName' => '店家'],
        ['name' => 'staff' , 'displayName' => '店家員工'],
        ['name' => 'customer' , 'displayName' => '顧客'],
    ],

    'permissions'=>[
        [
            'name'         => 'admin area',
            'displayName'  => '進入後台',
            'assignTo'     => ['manager','vendor','staff'],
        ],
        [
            'name'         => 'admin banner',
            'displayName'  => 'Banner設置',
            'assignTo'     => ['manager'],
        ],
        [
            'name'         => 'admin series',
            'displayName'  => '卡牌系列管理',
            'assignTo'     => ['manager'],
        ],
        [
            'name'         => 'admin card',
            'displayName'  => '卡牌管理',
            'assignTo'     => ['manager'],
        ],
        [
            'name'         => 'admin deck',
            'displayName'  => '牌組資料',
            'assignTo'     => ['manager'],
        ],
        [
            'name'         => 'admin product',
            'displayName'  => '產品管理',
            'assignTo'     => ['manager','vendor','staff'],
        ],
        [
            'name'         => 'admin order',
            'displayName'  => '訂單管理',
            'assignTo'     => ['manager','vendor','staff'],
        ],
        [
            'name'         => 'admin event',
            'displayName'  => '活動管理',
            'assignTo'     => ['manager'],
        ],
        [
            'name'         => 'admin user',
            'displayName'  => '會員管理',
            'assignTo'     => ['manager','vendor','staff'],
        ],
        [
            'name'         => 'admin vendor',
            'displayName'  => '店家管理',
            'assignTo'     => ['manager','vendor'],
        ],
        [
            'name'         => 'admin permission',
            'displayName'  => '權限管理',
            'assignTo'     => [],
        ],
        [
            'name'         => 'admin web setting',
            'displayName'  => '網站設定',
            'assignTo'     => [],
        ],
        [
            'name'         => 'admin option',
            'displayName'  => '一般設定',
            'assignTo'     => [],
        ],
        [
            'name'         => 'admin route list',
            'displayName'  => '路由列表',
            'assignTo'     => [],
        ],
        [
            'name'         => 'admin web log',
            'displayName'  => '網站歷史紀錄',
            'assignTo'     => [],
        ],
    ],
    // 預設的設定值
    'options' => [
        'site_name' => config('app.name'),
        'ptcg_standard' => 'E,F,G',
        'ptcg_expanded' => 'A,B,C,D,E,F,G',
    ],

];
