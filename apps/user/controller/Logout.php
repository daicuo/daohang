<?php
namespace app\user\controller;

use app\common\controller\Front;

class Logout extends Front
{
    
    public function _initialize()
    {
		parent::_initialize();
    }
    
    public function index()
    {
        \daicuo\User::logout();
        
        $this->success(lang('success'), 'user/login/index');
    }
}