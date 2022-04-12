<?php
/**
 * 按条件查询多个动态配置（key=>value）
 * @version 1.0.0 首次引入
 * @param array $args 必需;数组格式，常用(cache|controll);默认：空
 * @return mixed 成功时返回obj,失败时null
 */
function payConfig($args=[])
{
    $result = [];
    foreach(payConfigSelect($args) as $key=>$value){
        $result[$value['op_name']] = trim($value['op_value']);
    }
    return $result;
}

/**
 * 批量更新与新增动态配置
 * @version 1.0.0 首次引入
 * @param array $post 必需;数组格式（通常为表单提交的POST）;默认：空
 * @return mixed 成功时返回obj,失败时null
 */
function payConfigWrite($post=[])
{
    if(!$post){
        return null;
    }
    //重新组合字段
    $opControll = DcEmpty($post['op_controll'],'config');
    unset($post['op_controll']);
    //自动处理数据
    return DcConfigWrite($post, 'pay', $opControll, 'system', 0, 'no');
}

/**
 * 按条件批量删除动态配置
 * @param array $args 查询条件
 * @return int 影响条数
 */
function payConfigDelete($args=[])
{
    $args = DcArrayArgs($args,[
        'module'   => 'pay',
        'controll' => 'config',
        'action'   => 'system',
    ]);
    return DcConfigDelete($args);
}

/**
 * 按条件查询多个动态配置（原始数据）
 * @version 1.0.0 首次引入
 * @param array $args 必需;数组格式(cache|controll);默认：空
 * @return mixed 成功时返回array,失败时null
 */
function payConfigSelect($args=[])
{
    $args = DcArrayArgs($args,[
        'cache'       => true,
        'module'      => 'pay',
        'controll'    => 'config',
        'action'      => 'system',
        'sort'        => 'op_id',
        'order'       => 'asc',
    ]);
    return DcConfigSelect($args);
}

/**
 * 返回可用的支付平台列表
 * @version 1.0.0 首次引入
 * @return array 支付平台标识
 */
function payPlatForms()
{
    $platForms = [];
    foreach(config('pay.platforms') as $key=>$value){
        $config = payConfig(['cache'=>false,'controll'=>$key]);
        if($config['status'] == 'normal'){
            array_push($platForms, $key);
        }
    }
    return $platForms;
}

/**
 * 根据订单信息发起支付
 * @version 1.0.0 首次引入
 * @param array $post 必需;数组格式;默认：空
 * @return mixed false|支付表单
 */
function paySubmit($post=[])
{
    //应用名验证
    if(!$post['pay_module']){
        config('daicuo.error', lang('pay_error_module'));
        return false;
    }
    //充值金额验证
    if($post['pay_total_fee'] < 0.01){
        config('daicuo.error', lang('pay_error_mix'));
        return false;
    }
    //充值平台验证
    $platForms = config('pay.platforms');
    if( !in_array($post['pay_platform'], array_keys($platForms)) ){
        config('daicuo.error', lang('pay_error_forms'));
        return false;
    }
    //生成订单
    $post = payCreateOrder($post);
    //手机支付
    if($post['pay_scene']=='wap'){
        return model($platForms[$post['pay_platform']],'loglic')->createWap($post);
    }
    //电脑支付
    return model($platForms[$post['pay_platform']],'loglic')->create($post);
}

/**
 * 获取统一下单的订单信息
 * @version 1.0.0 首次引入
 * @param array $post 必需;支付数据表字段;默认：空
 * @return array 统一下单的订单
 */
function payCreateOrder($post=[])
{
    return model('pay/Common','loglic')->createOrder($post);
}

/**
 * 生成唯一订单号
 * @version 1.0.0 首次引入
 * @return strint 唯一订单号
 */
function payCreateSign()
{
    return date("YmdHis").mt_rand(10000, 99999);
}

/**
 * 返回呆错支付插件的所有数据表字段
 * @version 1.0.0 首次引入
 * @return array 数据表字段
 */
function payFields()
{
    return array_keys(DcFields('pay'));
}