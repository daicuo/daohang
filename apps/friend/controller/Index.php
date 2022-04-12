<?php
namespace app\friend\controller;

use app\common\controller\Front;

class Index extends Front
{
    public function _initialize()
    {
        parent::_initialize();
    }
    
    public function index()
    {
        $this->seo('index');
        
        return $this->fetch();
    }

    protected function seo($controll='index')
    {
        $this->assign([
            'seoTitle'       => $this->seoReplace(config('friend.'.$controll.'_title')),
            'seoKeywords'    => $this->seoReplace(config('friend.'.$controll.'_keywords')),
            'seoDescription' => $this->seoReplace(config('friend.'.$controll.'_description')),
        ]);
    }
    
    protected function seoReplace($string)
    {
        $search = ['[siteName]', '[siteDomain]', '[pageNumber]'];
        
        $replace = [config('common.site_name'), config('common.site_domain'), $this->site['page']];
        
        return DcEmpty(str_replace($search, $replace, $string), config('common.site_name'));
    }
}