<?php
namespace app\user\behavior;

use think\Controller;

class Hook extends Controller
{

    //表格数据
    public function tableBuild(&$params)
    {
        if($params['data-name']=='admin/user/index'){
            $params['columns']['user_score']['data-sortable'] = true;
            $params['columns']['user_pid']['data-sortable'] = true;
        }
    }
    
    // 用户注册前
    public function userRegisterBefore(&$post)
    {
        $post['user_pid']         = userPidGet();
        $post['user_score']       = intval(config('user.score_register'));
        $user['user_token']       = \daicuo\User::token_create(0);
        $user['user_expire']      = strtotime("+1 days");
        $user['user_create_time'] = '';
        $user['user_update_time'] = '';
        $post['user_module']      = 'user';
        $post['user_controll']    = 'register';
        $post['user_action']      = 'index';
    }
    
    // 用户注册后
    public function userRegisterAfter(&$user)
    {
        //注册初始积分日志
        if($user['user_id'] && config('user.score_register')){
            model('user/Log','loglic')->userScore($user['user_id'], config('user.score_register'), 'register', 'save');
        }
        //邀请注册奖励用户积分日志
        if($user['user_id'] && $user['user_pid'] && config('user.score_invite')){
            if( userScoreInc($user['user_pid'], config('user.score_invite')) ){
                model('user/Log','loglic')->userScore($user['user_pid'], config('user.score_invite'), 'invite', 'save');
            }
        }
    }
    
    // 用户登录前
    public function userLoginBefore(&$post)
    {
        
    }
    
    // 用户登录后
    public function userLoginAfter(&$data)
    {
        if($data['user_id']){
            db('user')->where('user_id',$data['user_id'])->setField('user_update_time',time());
        }
    }
    
    // 用户积分设置
    public function userScoreIndex(&$items)
    {
        
    }
}