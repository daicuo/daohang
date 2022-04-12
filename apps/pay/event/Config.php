<?php
namespace app\pay\event;

use app\common\controller\Addon;

class Config extends Addon
{
	
    public function _initialize()
    {
        parent::_initialize();
    }
    
    //支付平台配置
	public function index()
    {
        //所有支付平台列表(可自行扩展此字段)
        $platForms = config('pay.platforms');
        //当前支付平台
        $opControll = input('request.opControll/s','alipay');
        //获取支付平台已保存配置
        $data = payConfig([
            'cache'    => false,
            'controll' => $opControll,
        ]);
        //获取支付平台配置字段
        $fields = model($platForms[$opControll],'loglic')->fields($data);
        $fields['op_controll'] = [
            'type'    => 'hidden',
            'value'   => $opControll,
        ];
        //加载模板
        $this->assign('platForms', $platForms);
        $this->assign('opControll', $opControll);
        $this->assign('items', DcFormItems($fields));
        return $this->fetch('pay@config/index');
	}
    
    public function save()
    {
        $resulst = payConfigWrite(input('post.'));
		if( !$resulst ){
		    $this->error(lang('fail'));
        }
        $this->success(lang('success'));
    }
}