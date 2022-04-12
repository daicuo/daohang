<?php
namespace app\daohang\controller;

use app\common\controller\Front;

class Index extends Front
{

    public function _initialize()
    {
        parent::_initialize();
    }
    
    public function index()
    {
        $this->assign([
            'seoTitle'       => daohangSeo(config('daohang.index_title')),
            'seoKeywords'    => daohangSeo(config('daohang.index_keywords')),
            'seoDescription' => daohangSeo(config('daohang.index_description')),
            'searchList'     => explode(',',config('daohang.search_list')),
            'limitWeb'       => intval(config('daohang.limit_index_web')),
            'limitCategory'  => intval(config('daohang.limit_index_category')),
            'limitTag'       => intval(config('daohang.limit_index_tag')),
            'limitHot'       => intval(config('daohang.limit_index_hot')),
        ]);
        return $this->fetch();
    }
}