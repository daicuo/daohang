<?php
namespace app\user\loglic;
//充值回调接口
class Pay
{
    private $error = '';
    
    //返回错误信息
    public function getError(){
        return $this->error;
    }

    /**
     * 充值成功回调接口
     * @param array $post 通知参数
     * @param array $payInfo 数据库订单信息
     * @return int 影响条数
     */
    public function success($post=[], $payInfo=[])
    {
        //已处理过的订单直接退出
        if($payInfo['pay_status'] != 1){
            return false;
        }
        //积分充值业务
        if($payInfo['pay_module'] == 'user' && $payInfo['pay_controll'] == 'recharge' && $payInfo['pay_action'] == 'save'){
            return $this->rechargeScore($payInfo);
        }
        //默认返回
        return false;
    }
    
     /**
     * 充值失改回调接口
     * @param array $post 通知参数
     * @param array $payInfo 数据库订单信息
     * @return int 影响条数
     */
    public function fail($post=[], $payInfo=[]){
        return false;
    }
    
    /**
     * 通过订单信息充值积分
     * @param array $payInfo 充值订单
     * @return int 影响条数
     */
    private function rechargeScore($payInfo=[])
    {
        //积分比例
        $amount = $payInfo['pay_total_fee']*intval(config('user.score_recharge'));
        //增加积分成功后修改订单状态
        if( userScoreInc($payInfo['pay_user_id'], $amount) ){
            //更新支付状态为成功与记录原支付号
            $result = dbUpdate('pay/Pay', ['pay_id'=>$payInfo['pay_id']], ['pay_number'=>$payInfo['pay_number'],'pay_status'=>2]);
            //增加积分充值记录
            $resultLog = model('user/Log','loglic')->userScore($payInfo['pay_user_id'], $amount, 'recharge', 'save');
            //返回修改订单状态结果
            return $result;
        }
        return 0;
    }
}