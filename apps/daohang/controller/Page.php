<?php
namespace app\daohang\controller;

use app\common\controller\Front;

class Page extends Front
{

    public function _initialize()
    {
        parent::_initialize();
    }
    
    //首页
    public function index()
    {
        return $this->fetch();
    }
    
    //自定义
    public function _empty($name='')
    {
        $name = DcDirPath(DcHtml($name));
        if(is_file('./'.$this->site['path_view'].'page/'.$name.'.tpl')){
            return $this->fetch($name);
        }
        return $name;
    }
}