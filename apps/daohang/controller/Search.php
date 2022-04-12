<?php
namespace app\daohang\controller;

use app\common\controller\Front;

class Search extends Front
{

    public function _initialize()
    {
        //请求过滤
        $this->request->filter('trim,strip_tags,htmlspecialchars');
        //请求验证
        if( !daohangRequestCheck($this->request->ip(),$this->request->header('user-agent')) ){
            //$this->error(lang('dh_error_rest'), 'daohang/index/index');
        }
        //继承上级
        parent::_initialize();
        //post请求
        if( $this->request->isPost() ){
            $this->redirect(daohangUrlSearch($this->site['action'],['searchText'=>input('post.searchText/s')]),302);
        }
    }
    
    //站内搜索
    public function index()
    {
        //判断是否有关键词
        if( !$this->query['searchText'] ){
            $this->error(lang('dh_error_params'),'daohang/index/index');
        }
        
        //搜索限制验证
        if( !$this->requestCheck() ){
            $this->error(lang('dh_error_rest'), 'daohang/index/index');
        }
        
        //地址栏
        $info = [];
        $info['searchText'] = $this->query['searchText'];
        $info['pageSize']   = daohangLimit(config('daohang.limit_search'));
        $info['pageNumber'] = $this->site['page'];
        $info['sortName']   = 'info_order desc,info_views';
        $info['sortOrder']  = 'desc';
        
        //搜索引擎列表
        $info = $this->searchList($info);
    
        //分页路径
        $info['pagePath'] = daohangUrlSearch('index',[
            'searchText' => $info['searchText'],
            'pageNumber' => '[PAGE]',
        ]);
        
        //处理SEO优化
        $info['seoTitle'] = str_replace('[searchText]', $info['searchText'], daohangSeo(config('daohang.search_title')));
        $info['seoKeywords'] = str_replace('[searchText]', $info['searchText'], daohangSeo(config('daohang.search_keywords')));
        $info['seoDescription'] = str_replace('[searchText]', $info['searchText'], daohangSeo(config('daohang.search_description')));
        
        //查询数据
        $info['list'] = daohangSelect([
            'cache'      => true,
            'status'     => 'normal',
            'sort'       => $info['sortName'],
            'order'      => $info['sortOrder'],
            'limit'      => $info['pageSize'],
            'page'       => $info['pageNumber'],
            //'search'     => $info['searchText'],
            //'where'      => ['info_name'=>['like','%'.$info['searchText'].'%']],
            'whereOr'    => ['info_name'=>['like','%'.$info['searchText'].'%']],
            'meta_query' => [
                [
                    'key'   => ['eq','info_referer'],
                    'value' => ['like','%'.$info['searchText'].'%']
                ],
            ],
        ]);
        
        //模板变量
        $this->assign($info);
        
        //加载模板
        return $this->fetch();
    }
    
    public function baidu()
    {
        $this->redirect('https://www.baidu.com/s?wd='.$this->query['searchText'],302);
    }
    
    public function sogou()
    {
        $this->redirect('https://www.sogou.com/web?query='.$this->query['searchText'],302);
    }
    
    public function toutiao()
    {
        $this->redirect('https://so.toutiao.com/search?mod=website&keyword='.$this->query['searchText'],302);
    }
    
    public function bing()
    {
        $this->redirect('https://cn.bing.com/search?q='.$this->query['searchText'],302);
    }
    
    public function so()
    {
        $this->redirect('https://www.so.com/s?q='.$this->query['searchText'],302);
    }
    
    public function _empty($name='')
    {
        $searchList = [];
        foreach(explode(',',config('daohang.search_list')) as $key=>$value){
            $searchList[$value] = '';
        }
        //预留钩子
        \think\Hook::listen('daohang_search_list', $searchList);
        //$searchList['test'] = 'https://www.daicuo.org';
        //是否跳转(由钩子定义跳转的地址)
        if($searchList[$name]){
            $this->redirect($searchList[$name],302);
        }
        return $name;
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
        if( \daicuo\Auth::check('daohang/search/index', $this->site['user']['user_capabilities'], $this->site['user']['user_caps']) ){
            return true;
        }
        //客户端唯一标识
        $client = md5($this->request->ip().$this->request->header('user-agent'));
        //几秒内不得再次搜索(缓存标识未过期)
        if( DcCache('search'.$client) ){
            return false;
        }
        DcCache('search'.$client, 1, $configInterval);
        //未超出限制
        return true;
    }
    
    //第三方搜索引擎列表
    private function searchList($info=[])
    {
        //定义搜索列表
        foreach(explode(',',config('daohang.search_list')) as $key=>$name){
            $info['search_list'][$name] = daohangUrlSearch($name,['searchText' => $info['searchText']]);
        }
        return $info;
    }
}