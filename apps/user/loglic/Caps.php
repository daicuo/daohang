<?php
namespace app\user\loglic;

//单独管理权限节点时回调此文件

class Caps
{
    //后台权限节点
    public function back()
    {
        return [];
    }
    
    //前台权限节点
    public function front()
    {
        return [];
    }
}