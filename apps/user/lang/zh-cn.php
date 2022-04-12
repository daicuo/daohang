<?php
return [
    //错误信息
    'user_error_group_in'                    => '已经加入了该用户组，请勿重复操作',
    'user_error_group_none'                  => '该用户组不可升级，请勿操作',
    'user_error_score_less'                  => '积分不足，请先充值',
    'user_error_score_dec'                   => '扣除积分失败，请联系管理员',
    'user_error_score_inc'                   => '增加积分失败，请联系管理员',
    'user_error_group_update'                => '升级用户组失败，请联系管理员',
    'user_error_recharge_off'                => '积分充值暂未开放',
    'user_error_pay_none'                    => '积分充值功能未安装',
    'user_error_token_secret'                => '密钥错误',
    'user_error_token_expire'                => '授权码超时',
    'user_error_oauth_off'                   => '授权第三方帐号登录功能暂未开放',
    //成功信息
    'user_success_recharge'                  => '充值成功',
    
    //节点描述
    'user/admin/index'                       => '用户设置',
    'user/score/index'                       => '积分设置',
    'user/register/save'                     => '初始积分',
    'user/register/invite'                   => '邀请奖励',
    'user/recharge/save'                     => '积分充值',     
    
    //积分设置
    'user_score_register'                    => '注册赠送积分',
    'user_score_register_placeholder'        => '用户注册时赠送的积分，默认0',
    'user_score_invite'                      => '推广奖励积分',
    'user_score_invite_placeholder'          => '用户邀请新人成世注册时赠送的积分，设为0则不启用此功能',
    'user_score_recharge'                    => '积分充值比例',
    'user_score_recharge_placeholder'        => '1元人民币可充值多少个积分，设为0则不启用此功能',
    'subscriber_placeholder'                 => '升级到用户组（订阅者）一次性扣除积分',
    'contributor_placeholder'                => '升级到用户组（投稿者）一次性扣除积分',
    'vip_placeholder'                        => '升级到用户组（VIP）一次性扣除积分',
    'editor_placeholder'                     => '升级到用户组（编辑）一次性扣除积分',
    
    //用户设置
    'user_theme'                             => '模板主题（默认）',
    'user_theme_wap'                         => '模板主题（移动端）',
    'user_register_name'                     => '注册时填写用户名',
    'user_register_email'                    => '注册时填写邮箱',
    'user_register_mobile'                   => '注册时填写手机',
    'user_title_login'                       => '登录页标题',
    'user_title_login_placeholder'           => '自定义会员登录页网站标题，用于SEO优化',
    'user_keywords_login'                    => '登录页关键字',
    'user_keywords_login_placeholder'        => '自定义会员登录页网站关键字，用于SEO优化',
    'user_description_login'                 => '登录页描述',
    'user_description_login_placeholders'    => '自定义会员登录页网站描述，用于SEO优化',
    'user_title_register'                    => '注册页标题',
    'user_title_register_placeholder'        => '自定义会员注册页网站标题，用于SEO优化',	
    'user_keywords_register'                 => '注册页关键字',
    'user_keywords_register_placeholder'     => '自定义会员注册页网站关键字，用于SEO优化',
    'user_description_register'              => '注册页描述',
    'user_description_register_placeholder'  => '自定义会员注册页网站描述，用于SEO优化',
    'user_callback_secret'                   => '回调密钥',
    'user_callback_secret_placeholder'       => '多个网站统一用户登录时，回调生成的临时码加密密钥',
    'user_callback_domains'                  => '授权域名',
    'user_callback_domains_placeholder'      => '经过授权的域名才会进行回跳登录，留空不启用，多个用,号分隔',
    
    //通用字段
    'user_score'                             => '积分',
    'user_pid'                               => '邀请者',
    'user_score_register'                    => '注册积分',
    'user_score_invite'                      => '奖励积分',
    'user_score_recharge'                    => '积分充值',
];