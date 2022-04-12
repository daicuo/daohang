<?php
namespace app\user\controller;

use app\common\controller\Front;

class Repwd extends Front
{
    protected $auth = [
         'check'       => true,
         'none_login'  => '',
         'none_right'  => '*',
         'error_login' => 'user/login/index',
         'error_right' => 'user/login/index',
    ];
    
	public function _initialize()
    {
		parent::_initialize();
	}
    
	public function index()
    {
		return $this->fetch();
	}
    
    public function update()
    {
        //接收表单数据
        $post = [];
        $post['user_pass'] = input('post.user_pass/s');
        $post['user_pass_confirm'] = input('post.user_pass_confirm/s');
        $post['user_pass_old'] = input('post.user_pass_old/s');
         //旧密码验证
        if($this->site['user']['user_pass'] != md5($post['user_pass_old'])){
            $this->error('您输入的旧密码不正确','user/center/repwd');
        }
        //验证规则
        config('common.validate_name','user/User');
        config('common.validate_scene','repwd');
        //更新接口
        $result = \daicuo\User::update(['user_id'=>['eq',$this->site['user']['user_id']]], $post);
        if(!$result){
            $this->error(\daicuo\User::getError(),'user/repwd/index');
        }
        //退出当前登录
        \daicuo\User::logout();
        $this->success('密码修改成功，请重新登录','user/login/index');
	}
}