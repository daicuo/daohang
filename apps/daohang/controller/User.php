<?php
namespace app\daohang\controller;

use app\common\controller\Front;

class User extends Front
{
    protected $auth = [
         'check'       => true,
         'none_login'  => '',
         'none_right'  => '*',
         'error_login' => 'user/center/login',
         'error_right' => '',
    ];
    
	public function _initialize()
    {
		parent::_initialize();
	}
    
	public function index()
    {
		return $this->fetch();
	}
    
}