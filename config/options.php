<?php
use App\Http\Controllers\Admin\Menu;

return [
    // 設定的項目
    'fields' => [
        'normal_setting'=>[
            'label'=>'網站相關設定',
            'type'=>'label',
        ],
        'site_name' => [
            'label'     => '網站名稱',
            'validator' => 'required',
            'required'  => true
        ],
        'site_description' => [
            'label' => '網站簡介'
        ],
        'site_notify' => [
            'label' => '全站通知'
        ],
        'ptcg_setting'=>[
            'label'=>'寶可夢相關設定',
            'type'=>'label',
        ],
        'ptcg_standard' => [
            'label' => '標準賽標',
            'placeholder'=>'請用,分隔賽制標',
            'help'=>'請用,分隔賽制標'
        ],
        'ptcg_expanded' => [
            'label' => '開放賽標',
            'placeholder'=>'請用,分隔賽制標',
            'help'=>'請用,分隔賽制標'
        ],
    ],
];
