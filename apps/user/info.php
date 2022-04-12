<?php
return [
    //插件唯一标识
    'module'   => 'user',
    //插件名称
    'name'     => '呆错会员',
    //插件描述
    'info'     => '需要使用到框架的用户模块时进行统一管理用户注册、权限、积分等的核心应用！',
    //插件版本
    'version'  => '1.3.12',
    //依赖数据库
    'datatype' => ['sqlite', 'mysql'],
    //依赖插件版本
    'rely'     => [
        'daicuo' => '1.8.46',
    ],
];