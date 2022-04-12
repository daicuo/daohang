<?php
namespace app\adsense\controller;

use app\common\controller\Front;

class Hits extends Front
{

    public function _initialize()
    {
        parent::_initialize();
    }
		
    public function index()
    {
        return adsenseInfoInc(input('id/f'),'info_hits');
    }
}