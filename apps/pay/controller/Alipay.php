<?php
namespace app\pay\controller;

use app\common\controller\Front;

class Alipay extends Front
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
        //file_get_contents('php://input')
        return model('pay/Alipay','loglic')->notify($_POST);
    }
}