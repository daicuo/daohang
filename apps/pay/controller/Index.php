<?php
namespace app\pay\controller;

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
    
    public function save()
    {
        $post = [];
        $post['pay_platform']  = input('request.score_type/s', 'empty');//支付平台
        $post['pay_price']     = sprintf("%.2f",input('request.score_rmb/s', 1));//单价
        $post['pay_quantity']  = 1;//数量
        $post['pay_total_fee'] = $post['pay_price']*$post['pay_quantity'];//总价
        $post['notify_url']    = $this->site['domain'].DcUrl('pay/'.$post['pay_platform'].'/notify');//异步通知
        $post['return_url']    = $this->site['domain'].DcUrl('pay/index/notify');//同步通知
        $post['pay_info_id']   = 1;//内容ID
        $post['pay_user_id']   = $this->site['user']['user_id'];//用户ID
        $post['pay_module']    = 'pay';//应用名
        $post['pay_controll']  = 'index';//模块名
        $post['pay_action']    = 'save';//操作名
        $post['pay_scene']     = 'pc';//支付场景
        $post['pay_name']      = '任性打赏（'.config('common.site_name').'）';//商品描述
        //是否手机支付
        if($this->request->isMobile()){
            $post['pay_scene'] = 'wap';
        }
        //发起支付
        if($result = paySubmit($post)){
            return $result;
        }
        //支付失败
        $this->error(config('daicuo.error'), 'pay/index/index');
    }
    
    //同步通知
    public function notify()
    {
        $this->success('感谢老板的打赏！', 'pay/index/index');
    }
}