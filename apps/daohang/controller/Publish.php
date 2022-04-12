<?php
namespace app\daohang\controller;

use app\common\controller\Front;

class Publish extends Front
{
    //继承上级
    public function _initialize()
    {
        $this->request->filter('trim,strip_tags,htmlspecialchars');
        
        if( !daohangRequestCheck($this->request->ip(),$this->request->header('user-agent')) ){
            $this->error(lang('dh_error_rest'), 'daohang/index/index');
        }
        
        parent::_initialize();
    }
    
    //免费收录界面
    public function index()
    {
        $this->assign([
            'seoTitle'       => daohangSeo(config('daohang.publish_title')),
            'seoKeywords'    => daohangSeo(config('daohang.publish_keywords')),
            'seoDescription' => daohangSeo(config('daohang.publish_description')),
        ]);
        return $this->fetch();
    }
    
    //免费发布网站
    public function save()
    {
        //发布开关
        if(config('daohang.publish_save') != 'on'){
            $this->error(lang('dh_error_publish_off'));
        }
        //保存至数据库
        if( !DcArrayResult(daohangSave($this->post(),false)) ){
		    $this->error(\daicuo\Info::getError());
        }
        $this->success(lang('success'));
    }
    
    //更新网站发布
    private function curl()
    {
        $url = input('post.info_referer/s');
        if(!$url){
            $this->error('请输入待收录的网址');
        }
        $html = DcCurl('windows', 10, $url, '', 'https://www.daicuo.org');
        if(!$html){
            $this->error('您输入的网址不正确，请重新输入！');
        }
        //组合表单数据
        $data = [];
        $data['info_title']       = trim(DcPregMatch('<title>([\s\S]*?)<\/title>', $html));
        $data['info_keywords']    = trim(str_replace('，',',',DcPregMatch('<meta name="keywords" content="([\s\S]*?)"', $html)));
        $data['info_description'] = trim(DcPregMatch('<meta name="description" content="([\s\S]*?)"', $html));
    }
    
    //接收POST数据
    private function post()
    {
        $data = [];
        $data['info_name']        = input('post.info_name/s');
        $data['info_referer']     = input('post.info_referer/s');
        $data['info_content']     = input('post.info_content/s','网站简介未填写');
        $data['category_id']      = input('post.category_id/a');
        //必填字段
        if(!$data['info_name']){
            $this->error( lang('dh_error_name_require') );
        }
        if(!$data['category_id']){
            $this->error( lang('dh_error_category_require') );
        }
        //默认属性
        $data['info_views']       = rand(99,999);
        $data['info_hits']        = rand(9,99);
        $data['info_up']          = rand(99,999);
        $data['info_down']        = rand(9,99);
        $data['info_user_id']     = $this->site['user']['user_id'];
        $data['info_module']      = 'daohang';
        $data['info_controll']    = 'detail';
        $data['info_action']      = 'index';
        $data['info_type']        = 'index';
        $data['info_status']      = 'hidden';
        return $data;
    }
}