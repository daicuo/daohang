<?php
namespace app\daohang\loglic;

class Datas
{
    //配置
    public function insertConfig()
    {
        return model('common/Config','loglic')->install([
            'theme'                => 'default',
            'theme_wap'            => 'default',
            'slug_first'           => 1,
            'jump_page'            => 1,
            'publish_save'         => 'on',
            'score_fast'           => 10,
            'request_max'          => 0,
            'search_list'          => 'index,baidu,sogou,toutiao,bing,so',
            'search_interval'      => 0,
            'search_hot'           => '呆错网址导航系统,呆错后台管理框架,呆错文章管理系统,daicuo,feifeicms,gxcms',
            'label_strip'          => '<b>,<i>,<font>,<strong>',
            'post_pwd'             => '',
            'page_size'            => 30,
            'page_max'             => 100,
            'limit_search'         => 10,
            'limit_sitemap'        => 100,
            'limit_index_web'      => 60,
            'limit_index_category' => 30,
            'limit_index_tag'      => 60,
            'limit_index_hot'      => 10,
            'type_option'          => '',//属性扩展
            'auth_filter'          => ['vip'],
            'auth_search'          => ['vip'],
            'auth_save'            => ['vip'],
            'rewrite_index'        => 'dh$',
            'rewrite_category'     => 'dhtype/:slug/[:pageNumber]',
            'rewrite_tag'          => 'dhtag/:slug/[:pageNumber]',
            'rewrite_search'       => 'dhsearch/[:searchText]/[:pageNumber]',
            'rewrite_filter'       => 'dhfilter/<termId>-<pageSize>-<pageNumber>-<sortName>-<sortOrder>',
            'rewrite_detail'       => 'dhinfo/:slug$',
            'index_title'          => '呆错网址导航系统',
            'index_keywords'       => 'PHP导航系统,免费导航系统,开源导航系统',
            'index_description'    => '呆错导航系统是一款免费开源的分类导航建站系统，安全、便捷、高效、是您的建站首选。',
            'sitemap_title'        => '网站地图页',
            'sitemap_keywords'     => 'sitemap,网站地图',
            'sitemap_description'  => '[siteName]网站地图页展示网站结构。',
        ],'daohang');
    }
    
    //伪静态
    public function insertRoute()
    {
        config('common.validate_name', false);
        
        return model('common/Route','loglic')->install([
            [
                'rule'        => 'dh$',
                'address'     => 'daohang/index/index',
                'method'      => 'get',
            ],
            [
                'rule'        => 'dhtype/:slug/[:pageNumber]',
                'address'     => 'daohang/category/index',
                'method'      => 'get',
            ],
            [
                'rule'        => 'dhtag/:slug/[:pageNumber]',
                'address'     => 'daohang/tag/index',
                'method'      => 'get',
            ],
            [
                'rule'        => 'dhsearch/[:searchText]/[:pageNumber]',
                'address'     => 'daohang/search/index',
                'method'      => '*',
            ],
            [
                'rule'        => 'dhfilter/<termId>-<pageSize>-<pageNumber>-<sortName>-<sortOrder>',
                'address'     => 'daohang/filter/index',
                'method'      => 'get',
            ],
            [
                'rule'        => 'dhinfo/:slug$',
                'address'     => 'daohang/detail/index',
                'method'      => 'get',
            ],
        ],'daohang');
    }
    
    //权限
    public function insertAuth()
    {
        //权限节点
        $caps = [
            'daohang/filter/index',
            'daohang/search/index',
            'daohang/fast/save',
        ];
        
        //默认数据
        $default = [
            'op_name'       => 'vip',
            'op_module'     => 'daohang',
            'op_controll'   => 'auth',
            'op_action'     => 'front',//前台权限
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
    
    //后台菜单
    public function insertMenu()
    {
        $result = model('common/Menu','loglic')->install([
            [
                'term_name'   => '导航',
                'term_slug'   => 'daohang',
                'term_info'   => 'fa-link',
                'term_module' => 'daohang',
            ],
        ]);
        
        $result = model('common/Menu','loglic')->install([
            [
                'term_name'   => '网站管理',
                'term_slug'   => 'daohang/admin/index',
                'term_info'   => 'fa-list',
                'term_module' => 'daohang',
                'term_order'  => 9,
            ],
            [
                'term_name'   => '采集管理',
                'term_slug'   => 'daohang/collect/index',
                'term_info'   => 'fa-cloud',
                'term_module' => 'daohang',
                'term_order'  => 8,
            ],
            [
                'term_name'   => '栏目管理',
                'term_slug'   => 'admin/category/index?parent=daohang&term_module=daohang',
                'term_info'   => 'fa-clone',
                'term_module' => 'daohang',
                'term_order'  => 7,
            ],
            [
                'term_name'   => '标签管理',
                'term_slug'   => 'admin/tag/index?parent=daohang&term_module=daohang',
                'term_info'   => 'fa-tags',
                'term_module' => 'daohang',
                'term_order'  => 6,
            ],
            [
                'term_name'   => '频道设置',
                'term_slug'   => 'daohang/config/index',
                'term_info'   => 'fa-gear',
                'term_module' => 'daohang',
                'term_order'  => 5,
            ],
            [
                'term_name'   => 'SEO优化',
                'term_slug'   => 'daohang/seo/index',
                'term_info'   => 'fa-anchor',
                'term_module' => 'cms',
                'term_order'  => 4,
            ],
            [
                'term_name'   => '字段扩展',
                'term_slug'   => 'admin/field/index?parent=daohang&op_module=daohang',
                'term_info'   => 'fa-cube',
                'term_module' => 'daohang',
                'term_order'  => 3,
            ],
        ],'导航');
    }
    
    //前台导航
    public function insertNavs()
    {
        return model('common/Navs','loglic')->install([
            //导航栏
            [
                'navs_type'       => 'navbar',
                'navs_name'       => '导航首页',
                'navs_info'       => '呆错网址导航系统首页',
                'navs_url'        => 'daohang/index/index',
                'navs_status'     => 'normal',
                'navs_active'     => 'daohangindexindex',
                'navs_target'     => '_self',
                'navs_order'      => 99,
                'navs_parent'     => 0,
                'navs_module'     => 'daohang',
            ],
            [
                'navs_type'       => 'navbar',
                'navs_name'       => '热门网站',
                'navs_info'       => '网站排行榜',
                'navs_url'        => 'daohang/page/remen',
                'navs_status'     => 'normal',
                'navs_active'     => 'daohangpageremen',
                'navs_target'     => '_self',
                'navs_order'      => 1,
                'navs_parent'     => 0,
                'navs_module'     => 'daohang',
            ],
            [
                'navs_type'       => 'navbar',
                'navs_name'       => '免费收录',
                'navs_info'       => '免费发布网站',
                'navs_url'        => 'daohang/publish/index',
                'navs_status'     => 'normal',
                'navs_active'     => 'daohangpublishindex',
                'navs_target'     => '_self',
                'navs_order'      => 1,
                'navs_parent'     => 0,
                'navs_module'     => 'daohang',
            ],
            [
                'navs_type'       => 'navbar',
                'navs_name'       => '快审服务',
                'navs_info'       => '免审核发布网站',
                'navs_url'        => 'daohang/fast/index',
                'navs_status'     => 'normal',
                'navs_active'     => 'daohangfastindex',
                'navs_target'     => '_self',
                'navs_order'      => 1,
                'navs_parent'     => 0,
                'navs_module'     => 'daohang',
            ],
            //侧边栏
            [
                'navs_type'       => 'sitebar',
                'navs_name'       => '我的网址',
                'navs_info'       => '我发布的网址',
                'navs_url'        => 'daohang/user/index',
                'navs_status'     => 'private',
                'navs_active'     => 'daohanguserindex',
                'navs_target'     => '_self',
                'navs_order'      => 9,
                'navs_parent'     => 0,
                'navs_module'     => 'daohang',
            ],
            //底部链接
            [
                'navs_type'       => 'link',
                'navs_name'       => 'SiteMap',
                'navs_info'       => '呆错导航系统sitemap',
                'navs_url'        => 'daohang/sitemap/index',
                'navs_status'     => 'normal',
                'navs_active'     => 'daohangsitemapindex',
                'navs_target'     => '_self',
                'navs_order'      => 0,
                'navs_parent'     => 0,
                'navs_module'     => 'daohang',
            ],
            [
                'navs_type'       => 'link',
                'navs_name'       => '网站地图',
                'navs_info'       => '网站结构',
                'navs_url'        => 'daohang/page/index',
                'navs_status'     => 'normal',
                'navs_active'     => 'daohangpageindex',
                'navs_target'     => '_self',
                'navs_order'      => 0,
                'navs_parent'     => 0,
                'navs_module'     => 'daohang',
            ],
            [
                'navs_type'       => 'link',
                'navs_name'       => '最新收录',
                'navs_info'       => '最新收录的网站',
                'navs_url'        => 'daohang/page/zuixin',
                'navs_status'     => 'normal',
                'navs_active'     => 'daohangpagezuixin',
                'navs_target'     => '_self',
                'navs_order'      => 0,
                'navs_parent'     => 0,
                'navs_module'     => 'daohang',
            ],
            [
                'navs_type'       => 'link',
                'navs_name'       => '网站分类',
                'navs_info'       => '网站所有分类',
                'navs_url'        => 'daohang/category/all',
                'navs_status'     => 'normal',
                'navs_active'     => 'daohangcategoryall',
                'navs_target'     => '_self',
                'navs_order'      => 0,
                'navs_parent'     => 0,
                'navs_module'     => 'daohang',
            ],
            [
                'navs_type'       => 'link',
                'navs_name'       => '标签列表',
                'navs_info'       => '网站所有标签',
                'navs_url'        => 'daohang/tag/all',
                'navs_status'     => 'normal',
                'navs_active'     => 'daohangtagall',
                'navs_target'     => '_self',
                'navs_order'      => 0,
                'navs_parent'     => 0,
                'navs_module'     => 'daohang',
            ],
            [
                'navs_type'       => 'link',
                'navs_name'       => '免费收录',
                'navs_info'       => '免费收录网站',
                'navs_url'        => 'daohang/publish/index',
                'navs_status'     => 'normal',
                'navs_active'     => 'daohangpublishindex',
                'navs_target'     => '_self',
                'navs_order'      => 0,
                'navs_parent'     => 0,
                'navs_module'     => 'daohang',
            ],
            [
                'navs_type'       => 'link',
                'navs_name'       => '快审服务',
                'navs_info'       => '免审核发布网站',
                'navs_url'        => 'daohang/fast/index',
                'navs_status'     => 'normal',
                'navs_active'     => 'daohangfastindex',
                'navs_target'     => '_self',
                'navs_order'      => 0,
                'navs_parent'     => 0,
                'navs_module'     => 'daohang',
            ],
        ]);
    }
    
    //分类
    public function insertCategory()
    {
        //一级分类
        model('common/Category','loglic')->install([
            [
                'term_name'       => '网站大全',
                'term_slug'       => 'wzdq',
                'term_type'       => 'navbar',
                'term_module'     => 'daohang',
            ],
        ]);
        
        //二级分类
        $default = [
            'term_type'   => 'navbar',//是否导航栏显示
            'term_module' => 'daohang',
        ];
        $list = [];
        foreach(['生活服务','综合其他','休闲娱乐','教育文化','行业企业','网络科技','政府组织','购物网站','新闻媒体','交通旅游','医疗健康','体育健身'] as $key=>$value){
            $list[$key] = DcArrayArgs([
                'term_name' => $value,
                'term_slug' => DcPinYin($value),
                'term_info' => '收录与'.$value.'相关的网站',
            ],$default);
        }
        return model('common/Category','loglic')->install($list,'网站大全');
    }
    
    //字段
    public function insertField()
    {
        config('common.validate_name', false);
        
        return model('common/Field','loglic')->install([
            [
                'op_name'     => 'info_color',
                'op_value'    => json_encode([
                    'type'         => 'text',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'daohang',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'image_ico',
                'op_value'    => json_encode([
                    'type'         => 'image',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'daohang',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'image_level',
                'op_value'    => json_encode([
                    'type'         => 'image',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'daohang',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'info_up',
                'op_value'    => json_encode([
                    'type'         => 'number',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'daohang',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'info_down',
                'op_value'    => json_encode([
                    'type'         => 'number',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'daohang',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'info_referer',
                'op_value'    => json_encode([
                    'type'         => 'text',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'daohang',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'info_domain',
                'op_value'    => json_encode([
                    'type'         => 'text',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'daohang',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'info_unique',
                'op_value'    => json_encode([
                    'type'         => 'text',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'daohang',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'info_tpl',
                'op_value'    => json_encode([
                    'type'         => 'text',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'daohang',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
        ]);
    }
    
    // 添加采集规则
    public function insertCollect()
    {
        model('daohang/Collect','loglic')->write([
            'collect_name'     => '网址大全',
            'collect_url'      => 'http://api.daicuo.cc/wzdq/',
            'collect_token'    => '',
            'collect_category' => '',
        ]);
        return true;
    }
    
    //升级navbar
    public function updateNavs()
    {
        $list = DcTermSelect([
            'type' => 'navs',
        ]);
        //字段映射
        $navs = [];
        foreach($list as $key=>$value){
            $navs[$key]['term_id']       = $value['term_id'];
            $navs[$key]['term_parent']   = $value['term_parent'];
            $navs[$key]['term_name']     = $value['term_name'];
            $navs[$key]['term_slug']     = $value['navs_url'];
            $navs[$key]['term_type']     = str_replace(['navs','links'],['nav','link'],$value['term_action']);
            $navs[$key]['term_info']     = $value['term_info'];
            $navs[$key]['term_title']    = $value['navs_active'];
            $navs[$key]['term_keywords'] = $value['navs_ico'];
            $navs[$key]['term_description'] = $value['navs_image'];
            $navs[$key]['term_status']   = $value['term_status'];
            $navs[$key]['term_order']    = $value['term_order'];
            $navs[$key]['term_action']   = $value['navs_target'];
            $navs[$key]['term_controll'] = 'navs';
            $navs[$key]['term_module']   = $value['term_module'];
        }
        //取消唯一验证
        config('common.where_slug_unique', false);
        //批量更新
        $result = dbUpdateAll('term',$navs);
        //删除无用
        $result = db('termMeta')->where(['term_meta_key'=>['in',['navs_url','navs_image','navs_class','navs_active','navs_target']]])->delete();
        //返回结果
        return $result;
    }
    
    //转换分类
    public function updateCategory()
    {
        \think\Db::execute("update dc_term set term_controll='category' where term_type='category' and term_module='daohang';");
        
        \think\Db::execute("update dc_term set term_type='navbar' where term_controll='category' and term_module='daohang';");
    }
    
    //转换标签
    public function updateTag()
    {
        \think\Db::execute("update dc_term set term_controll='tag' where term_type='tag' and term_module='daohang';");
    }
    
    //删除队例
    public function deleteTerm($action='uninstall')
    {
        if($action=='update'){
            $ids = db('term')->where(['term_module'=>'daohang','term_controll'=>['in',['mp','mini']]])->limit(500)->column('term_id');
        }else{
            $ids = db('term')->where(['term_module'=>'daohang','term_type'=>['in',['category','tag','navs']]])->limit(500)->column('term_id');
        }
        
        db('termMap')->where(['term_id'=>['in',$ids]])->delete();
            
        db('termMeta')->where(['term_id'=>['in',$ids]])->delete();

        db('term')->where(['term_id'=>['in',$ids]])->delete();
        
        DcCacheTag('common/Term/Item', 'clear');
    }
    
    //删除内容
    public function deleteInfo($action='uninstall')
    {
        if($action=='update'){
            $ids = db('info')->where(['info_controll'=>['in',['mp','mini']]])->limit(500)->column('info_id');
        }else{
            $ids = db('info')->where(['info_module'=>'daohang'])->limit(500)->column('info_id');
        }
        
        db('termMap')->where(['detail_id'=>['in',$ids]])->delete();
        
        db('infoMeta')->where(['info_id'=>['in',$ids]])->delete();
        
        db('info')->where(['info_id'=>['in',$ids]])->delete();
        
        DcCacheTag('common/Info/Item', 'clear');
    }
}