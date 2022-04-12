<?php
namespace app\daohang\behavior;

use think\Controller;

class Hook extends Controller
{
    public function adminIndexHeader(&$params)
    {
        echo $this->fetch('daohang@count/index');
    }
    
    //前台权限扩展
    public function adminCapsFront(&$caps)
    {
        $caps = array_merge($caps,[
            'daohang/score/save',
            'daohang/fast/save',
            'daohang/filter/index',
            'daohang/search/index',
            'daohang/data/index',
        ]);
    }
    
    //后台权限扩展
    public function adminCapsBack(&$caps)
    {
        $caps = array_merge($caps,[
            'daohang/admin/index',
            'daohang/admin/save',
            'daohang/admin/delete',
            'daohang/collect/index',
            'daohang/collect/save',
            'daohang/collect/delete',
            'daohang/collect/write',
        ]);
    }
}