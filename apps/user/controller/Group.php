<?php
namespace app\user\controller;

use app\common\controller\Front;

class Group extends Front
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
    
	public function index()
    {
        $this->assign('capsFront', userCapsRoles('front'));

		return $this->fetch();
	}
    
	public function update()
    {
        $group = $this->query['value'];
        //验证是否已经加入该用户组
        if(in_array($group,$this->site['user']['user_capabilities'])){
            $this->error(lang('user_error_group_in'), 'user/center/index');
        }
        //验证用户组是否可升级（由后台积分设置控制）
        $configGroup = userGroupScore();
        if(!in_array($group, array_keys($configGroup))){
            $this->error(lang('user_error_group_none'), 'user/center/index');
        }
        //验证用户积分是否足够
        $configScore = intval(config('user.score_group_'.$group));
        if( $this->site['user']['user_score'] < $configScore ){
            $this->error(lang('user_error_score_less'), 'user/center/index');
        }
        //扣除用户积分
        $result = userScoreDec($this->site['user']['user_id'], $configScore);
        if(!$result){
            $this->error(lang('user_error_score_dec'), 'user/center/index');
        }
        //修改用户组
        $data = [];
        $data['user_id']           = $this->site['user']['user_id'];
        $data['user_capabilities'] = array_unique(DcArrayArgs([$group],$this->site['user']['user_capabilities']));
        $result = DcUserUpdateId($this->site['user']['user_id'], $data);
        if(!$result){
            $this->error(lang('user_error_group_update'), 'user/center/index');
        }
        //升级成功
        $this->success(lang('success'));
	}
}