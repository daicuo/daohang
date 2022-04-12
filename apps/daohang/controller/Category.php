<?php
namespace app\daohang\controller;

use app\common\controller\Front;

class Category extends Front
{
    // 继承上级
    public function _initialize()
    {
        if( !daohangRequestCheck($this->request->ip(),$this->request->header('user-agent')) ){
            $this->error(lang('dh_error_rest'), 'daohang/index/index');
        }
        parent::_initialize();
    }
    
    //category/index/?id=1&page=1
    public function index()
    {
        if( isset($this->query['id']) ){
            $info = daohangCategoryId($this->query['id']);
        }elseif( isset($this->query['slug']) ){
            $info = daohangCategorySlug($this->query['slug']);
        }elseif( isset($this->query['name']) ){
            $info = daohangCategoryName($this->query['name']);
        }else{
            $this->error(lang('mustIn'),'daohang/index/index');
        }
        if(!$info){
            $this->error(lang('empty'),'daohang/index/index');
        }
        //子分类
        $info['term_ids']   = DcTermSubIds($info['term_id'],'category','array');
        //分页路径
        $info['pagePath']   = daohangUrlCategory($info,'[PAGE]');
        //地址栏
        $info['pageSize']   = daohangLimit(config('daohang.page_size'));
        $info['pageNumber'] = $this->site['page'];
        $info['sortName']   = 'info_order desc,info_update_time';
        $info['sortOrder']  = 'desc';
        //SEO标签
        $info['seoTitle']       = daohangSeo(DcEmpty($info['term_title'],$info['term_name']),$this->site['page']);
        $info['seoKeywords']    = daohangSeo(DcEmpty($info['term_keywords'],$info['term_name']),$this->site['page']);
        $info['seoDescription'] = daohangSeo(DcEmpty($info['term_description'],$info['term_name']),$this->site['page']);
        //变量赋值
        $this->assign($info);
        //加载模板
        if($info['term_tpl']){
            return $this->fetch($info['term_tpl']);
        }
        return $this->fetch( DcEmpty($info['term_action'],'index') );
    }
    
    public function all()
    {
        $info = [];
        $info['seoTitle']       = daohangSeo(config('daohang.category_title'));
        $info['seoKeywords']    = daohangSeo(config('daohang.category_keywords'));
        $info['seoDescription'] = daohangSeo(config('daohang.category_description'));
        $this->assign($info);
        return $this->fetch('all');
    }
}