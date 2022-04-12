<?php
namespace app\user\controller;

use app\common\controller\Front;

class Oauth extends Front
{
    protected $auth = [
         'check'       => true,
         'none_login'  => '',
         'none_right'  => '*',
         'error_login' => 'user/index/login',
         'error_right' => 'user/index/login',
    ];
    
	public function _initialize()
    {
		parent::_initialize();
	}
    
    //第一步：扩展授权登录列表
    //第二步：检测user['oauth_'.第三方模块]是否有值
	public function index()
    {
        if(!config('user.oauth')){
            $this->error(lang('user_error_oauth_off'),'user/center/index');
        }
        //三方登录列表
        $list = [];
        foreach(config('user.oauth') as $key=>$value){
            $list[$value]['name']      = lang('oauth_'.$value);
            $list[$value]['isBind']    = DcEmpty($this->site['user']['oauth_'.$value],false);
            $list[$value]['urlBind']   = DcUrl($value.'/'.'bind/index');
            $list[$value]['urlDelete'] = DcUrl($value.'/'.'bind/delete');
        }
        $this->assign('list',$list);
		return $this->fetch();
	}
}