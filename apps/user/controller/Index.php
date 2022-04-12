<?php
namespace app\user\controller;

use app\common\controller\Front;

class Index extends Front
{
    
    public function _initialize()
    {
		parent::_initialize();
    }
    
    public function index()
    {
        return $this->fetch();
    }
    
    /**
     * 注册与登录前置操作
     * @param string $captcha 用户输入的验证码
     * @return array 用户信息
     */
    protected function indexBefore()
    {
        //是否已登录
        if( $this->site['user']['user_id'] ){
            $this->redirect(DcUrl('user/center/index'), 302);
        }
        //授权登录参数
        $post = [];
        $post['callback'] = DcHtml(input('request.callback/u',''));
        $post['state']    = DcHtml(input('request.state/s',''));
        $this->assign($post);
    }
    
    /**
     * 验证码验证
     * @param string $captcha 用户输入的验证码
     * @return array 用户信息
     */
    protected function validateCaptcha($captcha='')
    {
        if( DcBool(config('common.site_captcha')) ){
            if(captcha_check($captcha) == false){
                $this->error( DcError(lang('user_captcha_error')) );
            }
        }
    }
    
    /**
     * 授权回跳、不需要跳转时返回用户信息
     * @param array $user 当前用户信息
     * @param string $bakUrl 回跳网关
     * @param string $state 自定义参数
     * @return array 当前登录的用户信息
     */
    protected function callBack($user, $bakUrl='', $state='')
    {
        $redirect = model('user/Common','loglic')->callBack(['user_token'=>$user['user_token'],'user_expire'=>$user['user_expire']], $bakUrl, $state);
        if( $redirect ){
            //AjAX请求直接返回回跳链接
            if( $this->request->isAjax() ){
                return $redirect;
            }
            //POST请求直接跳转
            $this->redirect($redirect, 302);
        }
        return null;
    }
}