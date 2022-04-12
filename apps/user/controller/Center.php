<?php
namespace app\user\controller;

use app\common\controller\Front;

class Center extends Front
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
    
    //用户中心
	public function index()
    {
		return $this->fetch();
	}
}