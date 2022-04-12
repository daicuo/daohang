<?php
namespace app\daohang\controller;

use app\common\controller\Front;

class Detail extends Front
{

    public function _initialize()
    {
        if( !daohangRequestCheck($this->request->ip(),$this->request->header('user-agent')) ){
            $this->error(lang('dh_error_rest'), 'daohang/index/index');
        }
        parent::_initialize();
    }
    
    public function index()
    {
        if( isset($this->query['id']) ){
            $info = daohangId($this->query['id']);
        }elseif( isset($this->query['slug']) ){
            $info = daohangSlug($this->query['slug']);
        }elseif( isset($this->query['name']) ){
            $info = daohangName($this->query['name']);
        }else{
            $this->error(lang('mustIn'),'daohang/index/index');
        }
        //数据判断
        if(!$info){
            $this->error(lang('empty'),'daohang/index/index');
        }
        //增加人气值
        daohangInfoInc($info['info_id'], 'info_views');
        //SEO标签
        $info['seoTitle'] = daohangSeo(DcEmpty($info['info_title'],$info['info_name']));
        $info['seoKeywords'] = daohangSeo(DcEmpty($info['info_keywords'],$info['info_name']));
        $info['seoDescription'] = daohangSeo(DcEmpty($info['info_description'],$info['info_excerpt']));
        //变量赋值
        $this->assign($info);
        //加载模板
        if($info['info_tpl']){
            return $this->fetch($info['info_tpl']);
        }
        return $this->fetch();
    }
}