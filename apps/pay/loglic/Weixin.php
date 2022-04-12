<?php
namespace app\pay\loglic;

class Weixin 
{
    /**
     * 定义后台支付配置微信字段
     * @version 1.0.0 首次引入
     * @param array $post 必需;数组格式（通常为表单提交的POST）;默认：空
     * @return mixed 成功时返回obj,失败时null
     */
    public function fields($data=[])
    {
        return [
            'status' => [
                'type'        => 'radio', 
                'value'       => DcEmpty($data['status'],'hidden'),
                'option'      => ['normal'=>'正常','hidden'=>'暂停'],
                'title'       => '支付状态',
                'class_right_check' => 'form-check form-check-inline py-1',
            ],
        ];
    }
    
    public function create($post=[])
    {
        return '暂未开发';
	}
    
    public function createWap($post=[])
    {
        return '暂未开发';
    }
    
    public function notify($post=[])
    {
        return "success";
	}
}
?>