<?php
namespace app\adsense\event;

use app\common\controller\Addon;

class Union extends Addon
{
	
	public function _initialize()
    {
		parent::_initialize();
	}
    
    public function index()
    {
        $json = json_decode( DcCurl('auto',10,'http://hao.daicuo.cc/adsense/lianmeng/') , true);
        
        $this->assign($json);//['alert','item']
        
        return $this->fetch('adsense@union/index');
	}
}