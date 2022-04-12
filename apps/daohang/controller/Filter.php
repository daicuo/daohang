<?php
namespace app\daohang\controller;

use app\common\controller\Front;

class Filter extends Front
{
    //继承上级
    public function _initialize()
    {
        //请求过滤
        $this->request->filter('trim,strip_tags,htmlspecialchars');
        //请求验证
        if( !daohangRequestCheck($this->request->ip(),$this->request->header('user-agent')) ){
            $this->error(lang('dh_error_rest'), 'daohang/index/index');
        }
        //继承上级
        parent::_initialize();
        //频率验证
        if( !$this->requestCheck() ){
            $this->error(lang('dh_error_rest'), 'daohang/index/index');
        }
    }
    
    //按条件筛选页
    public function index()
    {
        //过滤空值
        $this->query        = DcArrayEmpty($this->query);
        //扩展字段列表
        $fieldsMeta         = DcArrayFilter($this->query, daohangMetaKeys('detail',NULL));
        //固定参数
        $info = [];
        $info['termId']     = intval($this->query['termId']);
        $info['termSlug']   = str_replace('termSlug','',$this->query['termSlug']);
        $info['termName']   = str_replace('termName','',$this->query['termName']);
        $info['pageSize']   = daohangLimit($this->query['pageSize']);
        $info['pageNumber'] = $this->site['page'];
        $info['sortName']   = daohangSortName($this->query['sortName'], 'info_update_time');
        $info['sortOrder']  = daohangSortOrder($this->query['sortOrder'], 'desc');
        //筛选参数
        $info['pageFilter'] = DcArrayEmpty(DcArrayArgs($fieldsMeta,$info));
        //分页PATH
        $info['pagePath']   = daohangUrlFilter( array_merge($info['pageFilter'],['pageNumber'=>'[PAGE]']) );
        //分页重置
        $info['pageReset']  = daohangUrlFilter([
            'termId'     => 0,
            'pageSize'   => 10,
            'pageNumber' => 1,
            'sortName'   => 'info_id',
            'sortOrder'  => 'desc'
        ]);
        //数据查询参数
        $args = [];
        $args['cache']    = true;
        $args['status']   = 'normal';
        $args['limit']    = $info['pageSize'];
        $args['page']     = $info['pageNumber'];
        $args['sort']     = $info['sortName'];
        $args['order']    = $info['sortOrder'];
        //按META字段条件筛选
        $args['meta_query'] = daohangMetaQuery($this->query);
        //按META字段排序
        if( !in_array($args['sort'],['info_id','info_order','info_views','info_hits','info_create_time','info_update_time']) ){
            $args['meta_key'] = $args['sort'];
            $args['sort']     = 'meta_value_num';
        }
        //分类ID限制
        if($info['termId']){
            $args['term_id'] = ['eq',intval($info['termId'])];
        }
        //分类别名限制
        if($info['termSlug']){
            $args['term_slug'] = ['eq',$info['termSlug']];
        }
        //分类名称限制
        if($info['termName']){
            $args['term_name'] = ['eq',$info['termName']];
        }
        //数据查询
        $info['list'] = daohangSelect($args);
        //URL参数
        $info['query'] = DcArrayEmpty($this->query);
        //分页大小列表
        $info['pageSizes'] = [
            '10'  => 10,
            '20'  => 20,
            '30'  => 30,
            '50'  => 50,
            '100' => 100,
        ];
        //排序字段列表
        $info['sortNames'] = [
            'info_views'       => lang('info_views'),
            'info_update_time' => lang('info_update_time'),
            'info_order'       => lang('info_order'),
            'info_up'          => lang('dh_up'),
            'info_id'          => 'ID',
        ];
        //排序方式列表
        $info['sortOrders'] = [
            'desc' => lang('dh_desc'),
            'asc'  => lang('dh_asc'),
        ];
        //当前模型所有分类
        $terms = daohangCategorySelect([
            'cache'    => true,
            'status'   => 'normal',
            'result'   => 'array',
            'action'   => 'index',
            'field'    => 'term_id,term_slug,term_name',
            'with'     => '',
            'limit'    => 0,
            'page'     => 0,
            'sort'     => 'term_count desc,term_id',
            'order'    => 'desc',
        ]);
        foreach($terms as $key=>$value){
            $info['termIds'][$value['term_id']] = $value['term_name'];
            $info['termSlugs'][$value['term_slug']] = $value['term_name'];
        }
        //当前分类或标签
        if( $info['termId'] ){
            $term = daohangCategoryId($info['termId']);
        }elseif( $info['termSlug'] ){
            $term = daohangCategorySlug($info['termSlug']);
        }elseif( $info['termName'] ){
            $term = daohangCategoryName($info['termName']);
        }
        //变量赋值
        $this->assign($info);
        $this->assign($term);
        //加载模板
        return $this->fetch();
    }
    
    //搜索请求是否合法（搜索间隔时长）
    private function requestCheck()
    {
        //后台验证开关
        $configInterval = intval(config('daohang.search_interval'));
        if($configInterval < 1){
            return true;
        }
        //搜索限制白名单
        if( \daicuo\Auth::check('daohang/filter/index', $this->site['user']['user_capabilities'], $this->site['user']['user_caps']) ){
            return true;
        }
        //客户端唯一标识
        $client = md5($this->request->ip().$this->request->header('user-agent'));
        //几秒内不得再次搜索(缓存标识未过期)
        if( DcCache('filter'.$client) ){
            return false;
        }
        DcCache('filter'.$client, 1, $configInterval);
        //未超出限制
        return true;
    }
}