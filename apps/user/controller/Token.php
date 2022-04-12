<?php
namespace app\user\controller;

use app\common\controller\Api;

class Token extends Api
{
    // 初始化
    public function _initialize()
    {
        $this->auth['none_login'] = ['user/token/index','user/token/login'];
        
		parent::_initialize();
    }
    
    // 通过code换取user/token/index/?code=xxx
    public function index()
    {
        $code = str_replace(['%20',' '], '+', input('get.code/s',''));
        
        $code = DcDesDecode($code, config('user.callback_secret'));
        
        if(!$code){
            $this->error( lang('user_error_token_secret') );
        }
        
        //拆分CODE
        list($token, $expire, $time) = explode(',', $code);
        
        //临时CODE超时
        if( time()-$time > 7200){
            $this->error( lang('user_error_token_expire') );
        }
        
        //返回token
        $this->success( lang('success'), ['user_token'=>$token, 'user_expire'=>$expire] );
    }
}