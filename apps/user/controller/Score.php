<?php
namespace app\user\controller;

use app\common\controller\Front;

class Score extends Front
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
    
    //积分日志
	public function index()
    {
        $where = [];
        $where['log_user_id'] = $this->site['user']['user_id'];
        $where['log_type']    = 'userScore';
        $items = model('common/Log','loglic')->all([
            'cache' => false,
            'limit' => 20,
            'page'  => $this->site['page'],
            'sort'  => 'log_id',
            'order' => 'desc',
            'where' => $where,
        ]);
        $this->assign($items);
        return $this->fetch();
	}
}