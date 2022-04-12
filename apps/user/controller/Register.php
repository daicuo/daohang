<?php
namespace app\user\controller;

use app\user\controller\Index;

class Register extends Index
{
    
    public function _initialize()
    {
		parent::_initialize();
    }
    
    //user/register/index/?pid=88
    public function index()
    {
        $this->indexBefore();
        
        //设置邀请ID
        userPidSet();
        
        //帐号、邮箱、手机必须启用一个
        if(!config('user.register_name') && !config('user.register_email') && !config('user.register_mobile')){
            config('user.register_name',true);
        }
        
        //加载模板
		return $this->fetch();
    }
    
	public function save()
    {

        $this->validateCaptcha(input('post.user_captcha'));//图形验证码
        
        config('common.validate_name', 'common/User');
        
        config('common.validate_scene', 'register');
        
        config('common.where_slug_unique', false);
 
        config('custom_fields.user_meta', model('common/User','loglic')->metaKeys());//扩展字段
        
        //提交表单
        $post = input('post.');
        $post['user_name'] = DcEmpty($post['user_name'], uniqid());
        
        //调用注册接口
        $user = \daicuo\User::register($post);
        //返回结果
        if($user['user_id'] < 1){
            $this->error(DcError(\daicuo\User::getError()), 'user/register/index');
        }
        //自动登录
        \daicuo\User::set_auth_cookie($user['user_id']);
        //是否为授权登录
        $redirect = $this->callBack($user, input('post.callback/u'), input('post.state/s'));
        $redirect = DcEmpty($redirect, DcUrl('user/center/index'));
        //直接返回
        $this->success(lang('success'), 'user/center/index', ['redirect'=>$redirect]);
	}
}