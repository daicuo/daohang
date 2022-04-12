<?php
namespace app\user\event;

use think\Controller;

class Score extends Controller
{
	
	public function _initialize()
    {
		parent::_initialize();
	}

	public function index()
    {
        $items = [
            'score_register' => [
                'type'        => 'number', 
                'value'       => intval(config('user.score_register')),
                'title'       => lang('user_score_register'),
                'placeholder' => lang('user_score_register_placeholder'),
            ],
            'score_invite' => [
                'type'        => 'number', 
                'value'       => intval(config('user.score_invite')),
                'title'       => lang('user_score_invite'),
                'placeholder' => lang('user_score_invite_placeholder'),
            ],
            'score_recharge' => [
                'type'        => 'number', 
                'value'       => intval(config('user.score_recharge')),
                'title'       => lang('user_score_recharge'),
                'placeholder' => lang('user_score_recharge_placeholder'),
            ],
            'html_hr' => [
                'type'        => 'html', 
                'value'       => '<hr>',
            ],
        ];
        
        //用户组积分
        foreach(userGroup() as $key=>$value){
            $items['score_group_'.$key] = [
                'type'        => 'number',
                'value'       => intval(config('user.score_group_'.$key)),
                'title'       => lang($key),
                'placeholder' => lang($key.'_placeholder'),
            ];
        }
        
        //预留钩子
        \think\Hook::listen('user_score_index', $items);
        
        //变量赋值
        $this->assign('items', DcFormItems($items));
        
        return $this->fetch('user@score/index');
	}
	
}