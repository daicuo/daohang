<?php
namespace app\pay\model;

use think\Model;

class Pay extends Model
{
    //开启自动写入时间戳
	protected $autoWriteTimestamp = true;

    //定义时间戳字段名
    protected $createTime = 'pay_create_time';
    protected $updateTime = 'pay_update_time';

    //数据自动完成
	protected $auto   = [];
    protected $insert = [];
    protected $update = [];
    
    //获取器不存在的字段
    protected $append = ['pay_status_text'];
    
    
    //获取器增加不存在的字段
    public function getPayStatusTextAttr($value, $data)
    {
        $status = ['1'=>'等待付款','2'=>'交易成功','3'=>'交易关闭'];
        return $status[$data['pay_status']];
    }
    
    //相对的关联一对一
    public function payUser(){
		return $this->belongsTo('app\common\model\User','pay_user_id')->field('user_id,user_name,user_email,user_mobile,user_status');
	}

    //相对的关联一对一
    public function payGoods(){
		return $this->belongsTo('app\common\model\Info','pay_info_id')->field('info_id,info_name,info_status,info_module,info_controll,info_action');
	}
}