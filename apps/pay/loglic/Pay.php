<?php
namespace app\pay\loglic;

//异步通知回调接口演示

class Pay
{
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
        //修改支付状态为成功
        return dbUpdate('pay/Pay', ['pay_id'=>$payInfo['pay_id']], ['pay_number'=>$payInfo['pay_number'],'pay_status'=>2]);
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
}
?>