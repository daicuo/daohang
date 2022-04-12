<?php
namespace app\adsense\controller;

use app\common\controller\Front;

//充值联盟广告链接

class Chongzhi extends Front{
    
    public function _empty($action)
    {
        $url = 'http://hao.daicuo.cc/adsense/youdu/?type='.$action.'&id='.config("common.site_id").'&host='.input('server.HTTP_HOST');
        
        $json = json_decode(DcCurl('auto', 3, $url), true);
        
        if($json['url']){
            $this->redirect($json['url'], 302);
        }
        
        return '广告已下线';
    }
    
}