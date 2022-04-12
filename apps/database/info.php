<?php
return [
    //插件唯一标识
    'module'   => 'database',
    //插件名称
    'name'     => '数据库管理',
    //插件描述
    'info'     => 'Mysql数据库管理插件、包含数据库转换、备份、还原、优化、SQL语句执行等数据维护功能！',
    //插件版本
    'version'  => '1.4.5',
    //依赖数据库
    'datatype' => ['sqlite', 'mysql'],
    //依赖插件版本
    'rely'     => [
        'daicuo' => '1.8.46',
    ],
];