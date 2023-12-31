<?php
use App\Http\Controllers\Admin\Menu;

return[
    'menu_detail' => [
        [
            'type' => 'item',
            'title' => '主控台',
            'func_name' => 'dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'permission' => 'admin area',
            'controller' => Menu\DashboardController::class,
        ],
        [
            'type' => 'item',
            'title' => 'Banner設置',
            'func_name' => 'banner',
            'icon' => 'fa fa-images',
            'permission' => 'admin banner',
            'controller' => Menu\BannersController::class,
        ],
        [
            'type' => 'item',
            'title' => '卡牌系列管理',
            'func_name' => 'series',
            'icon' => 'fa fa-layer-group',
            'permission' => 'admin series',
            'controller' => Menu\CardSeriesController::class,
        ],
        [
            'type' => 'item',
            'title' => '卡牌管理',
            'func_name' => 'card',
            'icon' => 'fa fa-chess-king',
            'permission' => 'admin card',
            'controller' => Menu\CardsController::class,
        ],
        [
            'type' => 'item',
            'title' => '牌組資料',
            'func_name' => 'deck',
            'icon' => 'fa fa-inbox',
            'permission' => 'admin deck',
            'controller' => Menu\DecksController::class,
        ],
        [
            'type' => 'item',
            'title' => '產品管理',
            'func_name' => 'product',
            'icon' => 'fa fa-box',
            'permission' => 'admin product',
            'controller' => Menu\ProductsController::class,
        ],
        [
            'type' => 'item',
            'title' => '訂單',
            'func_name' => 'order',
            'icon' => 'fa fa-shopping-cart',
            'permission' => 'admin order',
            'controller' => Menu\OrdersController::class,
        ],
        [
            'type' => 'item',
            'title' => '活動管理',
            'func_name' => 'event',
            'icon' => 'fa fa-flag',
            'permission' => 'admin event',
            'controller' => Menu\EventsController::class,
            'children'=>[
                [
                    'type' => 'item',
                    'title' => '活動分類',
                    'func_name' => 'eventClass',
                    'icon' => 'fas fa-list-ul',
                    'permission' => 'admin event',
                    'controller' => Menu\EventClassesController::class,
                ],
                [
                    'type' => 'item',
                    'title' => '活動列表',
                    'func_name' => 'event',
                    'icon' => 'fas fa-calendar-days',
                    'permission' => 'admin event',
                    'controller' => Menu\EventsController::class,
                ],
            ],
        ],
        [
            'type' => 'header',
            'title' => '後台管理',
            'func_name' => '',
            'icon' => '',
            'permission' => '',
            'controller' => '',
        ],
        [
            'type' => 'item',
            'title' => '店家管理',
            'func_name' => 'vendor',
            'icon' => 'fas fa-shop',
            'permission' => 'admin vendor',
            'controller' => Menu\VendorsController::class,
        ],
        [
            'type' => 'item',
            'title' => '會員管理',
            'func_name' => 'user',
            'icon' => 'fas fa-user',
            'permission' => 'admin user',
            'controller' => Menu\UsersController::class,
        ],
        [
            'type' => 'item',
            'title' => '權限管理',
            'func_name' => 'permission',
            'icon' => 'fas fa-lock',
            'permission' => 'admin permission',
            'controller' => Menu\PermissionsController::class,
        ],
        [
            'type' => 'item',
            'title' => '網站資訊&設定',
            'func_name' => 'web-setting',
            'icon' => 'fas fa-cogs',
            'permission' => 'admin web setting',
            'controller' => Menu\WebSettingController::class,
            'children'=>[
                [
                    'type' => 'item',
                    'title' => '一般網站設定',
                    'func_name' => 'option',
                    'icon' => 'fas fa-key',
                    'permission' => 'admin option',
                    'controller' => Menu\OptionsController::class,
                ],
                [
                    'type' => 'item',
                    'title' => '路由列表',
                    'func_name' => 'route-list',
                    'icon' => 'fas fa-sitemap',
                    'permission' => 'admin route list',
                    'controller' => Menu\RouteListController::class,
                ],
                [
                    'type' => 'item',
                    'title' => '操作紀錄',
                    'func_name' => 'website-log-history',
                    'icon' => 'fas fa-history ',
                    'permission' => 'admin web log',
                    'controller' => Menu\WebLogController::class,
                ],
            ],
        ],
    ],
];
