<?php
namespace app\pay\controller;

use app\common\controller\Front;

class Alipayold extends Front
{

    public function _initialize()
    {
        parent::_initialize();
    }
    
    public function index()
    {
        return 'index';
    }
    
    public function notify()
    {
        return model('pay/Alipayold','loglic')->notify($_POST);
    }
}