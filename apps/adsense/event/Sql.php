<?php
namespace app\adsense\event;

class Sql
{
    /**
    * 安装时触发/通常用于数据库操作或调用接口
    * @return bool 只有返回true时才会往下执行
    */
    public function install()
    {
        $this->write();
        //返回执行结果
        return true;
    }
    
    /**
    * 升级时触发/通常用于数据库操作
    * @return bool 只有返回true时才会往下执行
    */
    public function upgrade()
    {
        $this->write();
        //更新插件信息
        \daicuo\Apply::updateStatus('adsense', 'enable');
        //返回执行结果
        return true;
    }
    
    /**
    * 卸载插件时触发/通常用于数据库操作
    * @return bool 只有返回true时才会往下执行
    */
    public function remove()
    {
        return $this->unInstall();
    }
    
    /**
    * 删除插件时触发/通常用于数据库操作
    * @return bool 只有返回true时才会往下执行
    */
    public function unInstall()
    {
        model('common/Menu','loglic')->unInstall('adsense');
        
        model('common/Info','loglic')->unInstall('adsense');
        
        return true;
	}
    
    //公用安装与升级
    private function write()
    {
        $this->unInstall();
        
        model('adsense/Datas','loglic')->insertMenu();
        
        model('adsense/Datas','loglic')->insertData();
    }
}