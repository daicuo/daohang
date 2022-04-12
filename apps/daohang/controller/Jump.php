<?php
namespace app\daohang\controller;

use app\common\controller\Front;

class Jump extends Front
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
        //查询数据
        $info = daohangId($this->query['id']);
        //网址判断
        $info['url_jump'] = str_replace(['javascript:;','#'], '', $info['info_referer']);
        if(!$info['url_jump']){
            $this->error(lang('empty'),'daohang/index/index');
        }
        
        //增加点击数（一小时内有效点击一次）
        $client = md5('json'.$id.$this->request->ip().$this->request->header('user-agent'));
        if( !DcCache($client) ){
            daohangInfoInc($info['info_id'], 'info_hits');
        }else{
            DcCache($client, 1, 3600);
        }

        //加载模板
        if( config('daohang.jump_page') ){
            $info['seoTitle'] = daohangSeo(DcEmpty($info['info_title'],$info['info_name']));
            $info['seoKeywords'] = daohangSeo(DcEmpty($info['info_keywords'],$info['info_name']));
            $info['seoDescription'] = daohangSeo(DcEmpty($info['info_description'],$info['info_excerpt']));
            $this->assign($info);
            return $this->fetch();
        }
        
        //跳转收录网址
        $this->redirect($info['url_jump'], 302);
    }
}