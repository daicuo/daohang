<?php
//应用初始配置
return [
    'pay' => [
        //支付平台
        'platforms'  => [
            'alipay'    => 'pay/Alipay',
            'alipayold' => 'pay/Alipayold',
            'wxpay'     => 'pay/Weixin',
        ],
        //前端主题
        'theme'     => 'default',
        'theme_wap' => 'default',
    ]
];