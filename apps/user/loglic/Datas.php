<?php
namespace app\user\loglic;

class Datas
{
    //批量写入插件初始配置
    public function insertConfig()
    {
        return model('common/Config','loglic')->install([
            'theme'                   => 'default',
            'theme_wap'               => 'default',
            'register_name'           => true,
            'register_email'          => false,
            'register_mobile'         => false,
            'title_login'             => '用户登录',
            'keywords_login'          => '用户登录',
            'description_login'       => '已注册帐号请直接登录',
            'title_register'          => '用户注册',
            'keywords_register'       => '加入我们,免费注册',
            'description_register'    => '未注册帐号请先注册',
            'score_register'          => 10,
            'score_invite'            => 0,
            'score_recharge'          => 0,
            'score_group_contributor' => 10,
            'score_group_vip'         => 1000,
        ],'user');
    }
    
    //批量添加路由伪静态
    public function insertRoute()
    {
        model('common/Route','loglic')->unInstall('user');
        
        return model('common/Route','loglic')->install([
            [
                'rule'        => 'user$',
                'address'     => 'user/index/index',
                'method'      => 'get',
            ],
            [
                'rule'        => 'user/[:slug]$',
                'address'     => 'user/index/slug',
                'method'      => 'get',
            ],
            [
                'rule'        => 'login$',
                'address'     => 'user/login/index',
                'method'      => '*',
            ],
            [
                'rule'        => 'register$',
                'address'     => 'user/register/index',
                'method'      => '*',
            ],
            [
                'rule'        => 'ucenter$',
                'address'     => 'user/center/index',
                'method'      => 'get',
            ],
            [
                'rule'        => 'logout$',
                'address'     => 'user/logout/index',
                'method'      => 'get',
            ],
        ],'user');
    }
    
    //批量写入插件动态字段
    public function insertField()
    {
        model('common/Field','loglic')->unInstall('user');
        
        return model('common/Field','loglic')->install([
            [
                'op_name'     => 'user_pid',
                'op_value'    => json_encode([
                    'type'         => 'text',
                    'relation'     => 'eq',
                    'data-sortable'=> true,
                    'data-visible' => true,
                    'data-filter'  => true,
                ]),
                'op_module'   => 'user',
                'op_controll' => 'user',
                'op_action'   => 'index',
                'op_order'    => 7,
            ],
            [
                'op_name'     => 'user_score',
                'op_value'    => json_encode([
                    'type'         => 'number',
                    'relation'     => 'gt',
                    'data-sortable'=> true,
                    'data-visible' => true,
                    'data-filter'  => true,
                ]),
                'op_module'   => 'user',
                'op_controll' => 'user',
                'op_action'   => 'index',
                'op_order'    => 8,
            ],
        ]);
    }
    
    //批量添加初始用户
    public function insertUser()
    {
        config('common.validate_name', false);
        
        config('common.validate_scene', false);
        
        config('common.where_slug_unique', false);
        
        config('custom_fields.user_meta', ['user_capabilities', 'user_caps', 'user_expire', 'user_pid', 'user_score']);

        return \daicuo\User::save_all([
            [
                'user_name'         => 'user1',
                'user_nice_name'    => 'user1',
                'user_pass'         => 'user1',
                'user_email'        => 'user1@daicuo.org',
                'user_mobile'       => '13800138001',
                'user_status'       => 'normal',
                'user_token'        => 'user1',
                'user_expire'       => strtotime("+1 days"),
                'user_module'       => 'user',
                'user_capabilities' => ['subscriber'],
                'user_slug'         => 'userone',
                'user_score'        => 0,
                'user_pid'          => 0,
                'user_create_time'  => '',
                'user_update_time'  => '',
            ],
            [
                'user_name'         => 'user2',
                'user_nice_name'    => 'user2',
                'user_pass'         => 'user2',
                'user_email'        => 'user2@daicuo.org',
                'user_mobile'       => '13800138002',
                'user_status'       => 'normal',
                'user_token'        => 'user2',
                'user_expire'       => strtotime("+1 days"),
                'user_module'       => 'user',
                'user_capabilities' => ['subscriber'],
                'user_slug'         => 'usertwo',
                'user_score'        => 0,
                'user_pid'          => 0,
                'user_create_time'  => '',
                'user_update_time'  => '',
            ],
        ]);
    }
    
    //安装角色（用户组）
    public function insertRole()
    {
        model('common/Role','loglic')->unInstall('user');
        
        return model('common/Role','loglic')->install([
            [
                'op_name'     => 'vip',
                'op_value'    => '贵宾VIP',
                'op_module'   => 'user',
            ]
        ]);
    }
    
    //批量添加权限
    public function insertAuth()
    {
        model('common/Auth','loglic')->unInstall('user');
        
        //权限节点
        $caps = [
            'api/token/update',
            'api/token/refresh',
            'api/token/delete',
            'api/upload/save',
            'api/upload/delete',
        ];
        //默认数据
        $default = [
            'op_name'       => 'vip',
            'op_module'     => 'user',
            'op_controll'   => 'auth',
            'op_action'     => 'front',
            'op_order'      => 0,
            'op_status'     => 'normal',
        ];
        //批量添加数据
        $dataList = [];
        foreach($caps as $key=>$value){
            array_push($dataList, DcArrayArgs(['op_value'=>$value],$default));
        }
        
        //调用接口
        config('common.validate_name', false);
        return model('common/Auth','loglic')->install($dataList);
    }
    
    //批量添加后台菜单
    public function insertMenu()
    {
        model('common/Menu','loglic')->unInstall('user');
        
        return model('common/Menu','loglic')->install([
            [
                'term_name'   => '用户设置',
                'term_slug'   => 'user/admin/index?parent=user',
                'term_info'   => 'fa-gear',
                'term_module' => 'user',
                'term_order'  => 99,
            ],
            [
                'term_name'   => '积分设置',
                'term_slug'   => 'user/score/index?parent=user',
                'term_info'   => 'fa-btc',
                'term_module' => 'user',
                'term_order'  => 98,
            ],
            [
                'term_name'   => '字段扩展',
                'term_slug'   => 'admin/field/index?parent=user&op_module=user',
                'term_info'   => 'fa-cube',
                'term_module' => 'user',
                'term_order'  => 0,
            ],
            [
                'term_name'   => '菜单导航',
                'term_slug'   => 'admin/navs/index?parent=user&navs_module=user',
                'term_info'   => 'fa-navicon',
                'term_module' => 'user',
                'term_order'  => 0,
            ],
        ],'用户');
    }
    
    //批量添加前台导航
    public function insertNavs()
    {
        model('common/Navs','loglic')->unInstall('user');
        
        return model('common/Navs','loglic')->install([
            [
                'navs_type'       => 'navbar',
                'navs_name'       => '登录',
                'navs_info'       => '已注册帐号请登录',
                'navs_url'        => 'user/login/index',
                'navs_status'     => 'public',
                'navs_active'     => 'userloginindex',
                'navs_target'     => '_self',
                'navs_order'      => 0,
                'navs_parent'     => 0,
                'navs_module'     => 'user',
            ],
            [
                'navs_type'       => 'navbar',
                'navs_name'       => '注册',
                'navs_info'       => '免费注册帐号',
                'navs_url'        => 'user/register/index',
                'navs_status'     => 'public',
                'navs_active'     => 'userregisterindex',
                'navs_target'     => '_self',
                'navs_order'      => 0,
                'navs_parent'     => 0,
                'navs_module'     => 'user',
            ],
            [
                'navs_type'       => 'navbar',
                'navs_name'       => '用户中心',
                'navs_info'       => '用户中心首页',
                'navs_url'        => 'user/center/index',
                'navs_status'     => 'private',
                'navs_active'     => 'usercenterindex',
                'navs_target'     => '_self',
                'navs_order'      => 0,
                'navs_parent'     => 0,
                'navs_module'     => 'user',
            ],
            [
                'navs_type'       => 'navbar',
                'navs_name'       => '安全退出',
                'navs_info'       => '安全退出已登录帐号',
                'navs_url'        => 'user/logout/index',
                'navs_status'     => 'private',
                'navs_active'     => 'userlogoutindex',
                'navs_target'     => '_self',
                'navs_order'      => '-99',
                'navs_parent'     => 0,
                'navs_module'     => 'user',
            ],
            //侧边栏
            [
                'navs_type'       => 'sitebar',
                'navs_name'       => '用户中心',
                'navs_info'       => '用户中心首页',
                'navs_url'        => 'user/center/index',
                'navs_status'     => 'private',
                'navs_active'     => 'usercenterindex',
                'navs_target'     => '_self',
                'navs_order'      => 99,
                'navs_parent'     => 0,
                'navs_module'     => 'user',
            ],
            [
                'navs_type'       => 'sitebar',
                'navs_name'       => '积分充值',
                'navs_info'       => '充值网站积分',
                'navs_url'        => 'user/recharge/index',
                'navs_status'     => 'private',
                'navs_active'     => 'userrechargeindex',
                'navs_target'     => '_self',
                'navs_order'      => 89,
                'navs_parent'     => 0,
                'navs_module'     => 'user',
            ],
            [
                'navs_type'       => 'sitebar',
                'navs_name'       => '充值记录',
                'navs_info'       => '网站积分充值记录',
                'navs_url'        => 'user/recharge/log',
                'navs_status'     => 'hidden',
                'navs_active'     => 'userrechargelog',
                'navs_target'     => '_self',
                'navs_order'      => 79,
                'navs_parent'     => 0,
                'navs_module'     => 'user',
            ],
            [
                'navs_type'       => 'sitebar',
                'navs_name'       => '帐号升级',
                'navs_info'       => '升级到相应的用户组',
                'navs_url'        => 'user/group/index',
                'navs_status'     => 'private',
                'navs_active'     => 'usergroupindex',
                'navs_target'     => '_self',
                'navs_order'      => 69,
                'navs_parent'     => 0,
                'navs_module'     => 'user',
            ],
            [
                'navs_type'       => 'sitebar',
                'navs_name'       => '帐号绑定',
                'navs_info'       => '绑定第三方帐号登录',
                'navs_url'        => 'user/oauth/index',
                'navs_status'     => 'private',
                'navs_active'     => 'useroauthindex',
                'navs_target'     => '_self',
                'navs_order'      => 59,
                'navs_parent'     => 0,
                'navs_module'     => 'user',
            ],
            [
                'navs_type'       => 'sitebar',
                'navs_name'       => '积分日志',
                'navs_info'       => '网站积分增减记录',
                'navs_url'        => 'user/score/index',
                'navs_status'     => 'private',
                'navs_active'     => 'userscoreindex',
                'navs_target'     => '_self',
                'navs_order'      => 49,
                'navs_parent'     => 0,
                'navs_module'     => 'user',
            ],
            [
                'navs_type'       => 'sitebar',
                'navs_name'       => '修改密码',
                'navs_info'       => '修改用户密码',
                'navs_url'        => 'user/repwd/index',
                'navs_status'     => 'private',
                'navs_active'     => 'userrepwdindex',
                'navs_target'     => '_self',
                'navs_order'      => '-98',
                'navs_parent'     => 0,
                'navs_module'     => 'user',
            ],
            [
                'navs_type'       => 'sitebar',
                'navs_name'       => '安全退出',
                'navs_info'       => '安全退出已登录帐号',
                'navs_url'        => 'user/logout/index',
                'navs_status'     => 'private',
                'navs_active'     => 'userlogoutindex',
                'navs_target'     => '_self',
                'navs_order'      => '-99',
                'navs_parent'     => 0,
                'navs_module'     => 'user',
            ],
        ]);
    }
    
    //插件卸载
    public function unInstall()
    {
        //先按角色删除权限节点
        db('op')->where(['op_controll'=>'auth','op_name'=>['eq','vip']])->delete();
        //删除插件配置
        \daicuo\Op::delete_module('user');
        //删除插件用户
        \daicuo\User::delete_module('user');
        //删除插件分类/标签/导航
        \daicuo\Term::delete_module('user');
        //直接返回结果
        return true;
    }
    
}