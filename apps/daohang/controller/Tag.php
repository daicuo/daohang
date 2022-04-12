<?php
namespace app\daohang\controller;

use app\common\controller\Front;

class Tag extends Front
{
    //继承上级
    public function _initialize()
    {
        if( !daohangRequestCheck($this->request->ip(),$this->request->header('user-agent')) ){
            $this->error(lang('dh_error_rest'), 'daohang/index/index');
        }
        parent::_initialize();
    }
    
    //daohang/tag/index/?id=88&pageNumber=2
    public function index()
    {
        if( isset($this->query['id']) ){
            $info = daohangTagId($this->query['id']);
        }elseif( isset($this->query['slug']) ){
            $info = daohangTagSlug($this->query['slug']);
        }elseif( isset($this->query['name']) ){
            $info = daohangTagName($this->query['name']);
        }else{
            $this->error(lang('mustIn'),'daohang/index/index');
        }
        if(!$info){
            $this->error(lang('empty'),'daohang/index/index');
        }
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
        return $this->fetch();
    }
    
    //daohang/tag/all/?pageNumber=2
    public function all()
    {
        $info = [];
        $info['seoTitle']       = daohangSeo(config('daohang.tag_title'));
        $info['seoKeywords']    = daohangSeo(config('daohang.tag_keywords'));
        $info['seoDescription'] = daohangSeo(config('daohang.tag_description'));
        $info['pagePath']       = daohangUrl('daohang/tag/all',['pageNumber'=>'[PAGE]']);
        $info['pageSize']       = DcEmpty(intval(config('daohang.page_size')),20);
        $info['pageNumber']     = DcEmpty($this->query['pageNumber'], $this->site['page']);
        $info['sortName']       = 'term_count desc,term_id';
        $info['sortOrder']      = 'desc';
        $this->assign($info);
        return $this->fetch();
    }
}