<?php
namespace app\adsense\controller;

use app\common\controller\Front;

class Index extends Front
{

    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        $item = adsenseAll([
            'cache'      => true,
            'status'     => 'normal',
            //'search'   => 'ads',
            //'limit'    => 2,
            //'page'     => 1,
        ]);
        $this->assign('item', $item);
        return $this->fetch();
    }
    
    // readID
    public function read()
    {
        return adsenseInfoContent( adsenseGetId(input('id/d')) );
    }
    
    // readSlug
    public function slug()
    {
        return adsenseInfoContent( adsenseGetSlug(input('id/s')) );
    }
}