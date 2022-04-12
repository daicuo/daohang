<?php
namespace app\friend\loglic;

class Datas
{
    //批量写入插件初始配置
    public function insertConfig()
    {
        return \daicuo\Op::write([
            'theme'                => 'default',
            'theme_wap'            => 'default',
            'index_title'          => '友情链接',
            'index_keywords'       => '友情链接列表,友情链接插件',
            'index_description'    => '欢迎使用呆错友情链接插件，支持免费自助申请！',
            'publish_title'        => '免费申请',
            'publish_keywords'     => '友情链接,自助友情链接,友情链接插件',
            'publish_description'  => '免费申请友情链接前请先做好本站的链接！',
        ],'friend','config','system','0','yes');
    }
    
    //批量添加扩展字段
    public function insertField()
    {
        config('common.validate_name', '');
        
        return model('common/Field','loglic')->install([
            [
                'op_name'     => 'friend_referer',
                'op_value'    => json_encode([
                    'type'         => 'text',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'friend',
                'op_controll' => 'detail',
                'op_action'   => 'index',
            ],
            [
                'op_name'     => 'friend_logo',
                'op_value'    => json_encode([
                    'type'         => 'text',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'friend',
                'op_controll' => 'detail',
                'op_action'   => 'index',
            ]
        ]);
    }
    
    //批量添加路由伪静态
    public function insertRoute()
    {
        config('common.validate_name', '');
        
        return model('common/Route','loglic')->install([
            [
                'rule'        => 'friend$',
                'address'     => 'friend/index/index',
                'method'      => 'get',
                'op_module'   => 'friend',
                'op_controll' => 'route',
                'op_action'   => 'system',
            ],
        ]);
    }
    
    //批量添加后台菜单
    public function insertMenu()
    {
        $result = model('common/Menu','loglic')->install([
            [
                'term_name'   => '友链',
                'term_slug'   => 'friend',
                'term_info'   => 'fa-handshake-o',
                'term_module' => 'friend',
            ],
        ]);
        
        $result = model('common/Menu','loglic')->install([
            [
                'term_name'   => '友链管理',
                'term_slug'   => 'friend/admin/index',
                'term_info'   => 'fa-navicon',
                'term_module' => 'friend',
                'term_order'  => 9,
            ],
            [
                'term_name'   => '基本设置',
                'term_slug'   => 'friend/config/index',
                'term_info'   => 'fa-gear',
                'term_module' => 'friend',
                'term_order'  => 0,
            ],
        ],'友链');
    }
    
    //批量添加前台导航
    public function insertNavs()
    {
        return model('common/Navs','loglic')->install([
            [
                'navs_name'       => '申请友链',
                'navs_url'        => 'friend/publish/index',
                'navs_type'       => 'link',
                'navs_module'     => 'friend',
                'navs_active'     => 'friendpublishindex',
                'navs_target'     => '_self',
            ],
        ]);
    }
    
    //批量添加友链
    public function insertFriend()
    {
        config('common.validate_name', '');
        
        config('common.validate_scene', '');
        
        config('common.where_slug_unique', false);
        
        config('custom_fields.info_meta', ['friend_referer','logo_referer']);

        $list = [
            [
                'info_name'      => '呆错开发框架',
                'friend_referer' => 'https://www.daicuo.org',
                'info_order'     => 99,
                'info_module'    => 'friend',
                'info_controll'  => 'detail',
                'info_action'    => 'index',
                'info_staus'     => 'normal',
            ],
            [
                'info_name'      => '飞飞影视系统',
                'friend_referer' => 'https://www.feifeicms.org',
                'info_order'     => 98,
                'info_module'    => 'friend',
                'info_controll'  => 'detail',
                'info_action'    => 'index',
                'info_staus'     => 'normal',
            ],
            [
                'info_name'      => '呆错站长论坛',
                'friend_referer' => 'http://bbs.daicuo.org',
                'info_order'     => 97,
                'info_module'    => 'friend',
                'info_controll'  => 'detail',
                'info_action'    => 'index',
                'info_staus'     => 'normal',
            ],
        ];
        
        foreach($list as $key=>$post){
            \daicuo\Info::save($post, 'info_meta');
        }
        
        return true;
    }
    
    //按插件应用名删除数据
    public function delete()
    {
        //删除插件配置
        \daicuo\Op::delete_module('friend');
    
        //删除插件分类/标签/导航/菜单
        model('common/Term','loglic')->unInstall('friend');
        
        //删除内容数据
        model('common/Info','loglic')->unInstall('friend');
    }
    
}