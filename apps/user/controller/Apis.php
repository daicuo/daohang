<?php
namespace app\user\controller;

use app\common\controller\Api;

class Apis extends Api
{
    // 初始化
    public function _initialize()
    {
        $this->auth['none_login'] = '';
        
        $this->auth['none_right'] = ['user/apis/index'];
        
		parent::_initialize();
    }
    
    // 获取用户资料
    public function index()
    {
        $user = $this->site['user'];
        
        unset($user['user_pass']);
        
        $this->success('成功', $user);
    }

}