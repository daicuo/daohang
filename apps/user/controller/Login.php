<?php
namespace app\user\controller;

use app\user\controller\Index;

class Login extends Index
{

    public function _initialize()
    {
		parent::_initialize();
    }
    
    public function index()
    {
        $this->indexBefore();
        
        return $this->fetch();
    }
    
    public function update()
    {
        //图形验证码
        $this->validateCaptcha(input('post.user_captcha'));
        //验证用户名密码
        $post = [];
        $post['user_name']   = input('post.user_name/s');
        $post['user_pass']   = input('post.user_pass/s');
        $post['user_expire'] = input('post.user_expire/d',0);//保持登录
        if( !\daicuo\User::login($post) ){
            $this->error(DcError(\daicuo\User::getError()), 'user/login/index');
        }
        //当前登录用户信息
        $user = \daicuo\User::get_current_user();
        //是否为授权登录
        $redirect = $this->callBack($user, input('post.callback/u'), input('post.state/s'));
        $redirect = DcEmpty($redirect, DcUrl('user/center/index'));
        //直接返回
        $this->success(lang('success'), 'user/center/index', ['redirect'=>$redirect]);
    }
    
}