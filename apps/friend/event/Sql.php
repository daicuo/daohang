<?php
namespace app\friend\event;

class Sql
{
    /**
    * 安装时触发
    * @return bool 只有返回true时才会往下执行
    */
	public function install()
    {
        //初始配置
        model('friend/Datas','loglic')->insertConfig();
        
        //初始字段
        model('friend/Datas','loglic')->insertField();
        
        //初始路由
        model('friend/Datas','loglic')->insertRoute();
        
        //初始菜单
        model('friend/Datas','loglic')->insertMenu();
        
        //初始导航
        model('friend/Datas','loglic')->insertNavs();
        
        //初始数据
        model('friend/Datas','loglic')->insertFriend();
        
        //更新缓存
        \think\Cache::clear();
        
        //返回结果
        return true;
	}
    
    /**
    * 升级时触发
    * @return bool 只有返回true时才会往下执行
    */
    public function upgrade()
    {
        model('friend/Datas','loglic')->delete();
        
        $this->install();
        
        \daicuo\Apply::updateStatus('friend', 'enable');
        
        return true;
    }
    
    /**
    * 卸载时触发
    * @return bool 只有返回true时才会往下执行
    */
    public function remove()
    {
        model('friend/Datas','loglic')->delete();
        
        return true;
    }
    
    /**
    * 删除时触发
    * @return bool 只有返回true时才会往下执行
    */
    public function unInstall()
    {
        model('friend/Datas','loglic')->delete();
        
        return true;
	}
}