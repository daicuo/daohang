<?php
namespace app\friend\controller;

use app\friend\controller\Index;

class Publish extends Index
{
    public function _initialize()
    {
        parent::_initialize();
    }
    
    public function index()
    {
        $items = [];
        
        $items['info_name'] = [
            'type'            => 'text',
            'required'        => true,
            'title'           => lang('friend_name'),
            'class_left'      => 'col-12',
            'class_right'     => 'col-12',
        ];
        
        $items['friend_referer'] = [
            'type'            => 'url',
            'required'        => true,
            'title'           => lang('friend_url'),
            'class_left'      => 'col-12',
            'class_right'     => 'col-12',
        ];
        
        $items['friend_logo'] = [
            'type'            => 'image',
            'required'        => false,
            'title'           => lang('friend_logo'),
            'class_left'      => 'col-12',
            'class_right'     => 'col-12',
        ];
        
        if( DcBool(config('common.site_captcha')) ){
            $items['info_captcha'] = [
                'type'            => 'captcha',
                'required'        => true,
                'title'           => lang('friend_captcha'),
                'class_left'      => 'col-12',
                'class_right'     => 'col-12',
            ];
        }
        
        $this->assign('items', DcFormItems($items));
        
        $this->seo('publish');
        
        return $this->fetch();
    }
    
    public function save()
    {
        //表单数据
        $post = input('post.');
        $post = DcArrayFilter($post,['info_name','friend_referer','friend_logo','info_captcha']);
        
        //验证码
        if( DcBool(config('common.site_captcha')) ){
            if(captcha_check($post['info_captcha']) == false){
                $this->error( DcError(lang('user_captcha_error')) );
            }
        }
        
        //预留钩子
        \think\Hook::listen('friend_publish_save', $post);
        
        //数据库
        if( !friendSave($post) ){
            $this->error(\daicuo\Info::getError());
        }
        $this->success(lang('success'));
    }
}