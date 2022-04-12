<?php
namespace app\user\controller;

use app\common\controller\Front;

class Recharge extends Front
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
    
	public function index()
    {
        $this->ratio();
        
        //未安装支付插件
        if( !function_exists('payPlatForms') ){
            $this->error(lang('user_error_pay_none'), 'user/center/index');
        }
        
        //加载模板
		return $this->fetch();
	}
    
    //发起支付
	public function save()
    {
        $post = [];
        $post['pay_platform']  = input('request.platform/s', 'empty');//支付平台
        $post['pay_price']     = sprintf("%.2f",input('request.value/s', 1));//单价
        $post['pay_quantity']  = 1;//数量
        $post['pay_total_fee'] = $post['pay_price']*$post['pay_quantity'];//总价
        $post['notify_url']    = $this->site['domain'].DcUrl('pay/'.$post['pay_platform'].'/notify');//异步通知
        $post['return_url']    = $this->site['domain'].DcUrl('user/recharge/notify');//同步通知
        $post['pay_info_id']   = 1;//内容ID
        $post['pay_user_id']   = $this->site['user']['user_id'];//用户ID
        $post['pay_module']    = 'user';//应用名
        $post['pay_controll']  = 'recharge';//模块名
        $post['pay_action']    = 'save';//操作名
        $post['pay_scene']     = 'pc';//支付场景
        $post['pay_name']      = lang('user/recharge/save').'（'.config('common.site_name').'）';//商品描述
        //是否手机支付
        if($this->request->isMobile()){
            $post['pay_scene'] = 'wap';
        }
        //发起支付
        if($result = paySubmit($post)){
            return $result;
        }
        //支付失败
        $this->error(config('daicuo.error'), 'user/recharge/index');
	}
    
    //回调通知
    public function notify()
    {
        $this->success(lang('user_success_recharge'), 'user/recharge/index');
    }
    
    //充值记录
    public function log()
    {
        $this->ratio();
        
        $items = model('pay/Common','loglic')->all([
            'cache' => false,
            'limit' => 20,
            'page'  => $this->site['page'],
            'sort'  => 'pay_id',
            'order' => 'desc',
            'with'  => '',
            'where' => [
                'pay_user_id' => ['eq',$this->site['user']['user_id']],
            ]
        ]);
        $this->assign(DcArrayResult($items));
        return $this->fetch();
    }
    
    //验证充值开关（积分充值比例）
    private function ratio()
    {
        if(config('user.score_recharge') < 1){
            $this->error(lang('user_error_recharge_off'), 'user/center/index');
        }
    }
}