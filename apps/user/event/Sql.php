<?php
namespace app\user\event;

class Sql
{
    /**
    * 安装时触发
    * @return bool 只有返回true时才会往下执行
    */
	public function install()
    {
        //初始配置
        model('user/Datas','loglic')->insertConfig();
        
        //初始路由
        model('user/Datas','loglic')->insertRoute();
        
        //扩展字段
        model('user/Datas','loglic')->insertField();
        
        //后台菜单
        model('user/Datas','loglic')->insertMenu();
        
        //初始用户
        model('user/Datas','loglic')->insertUser();
        
        //初始角色
        model('user/Datas','loglic')->insertRole();
        
        //初始权限
        model('user/Datas','loglic')->insertAuth();
        
        //前台菜单（导航栏、侧边栏等）
        model('user/Datas','loglic')->insertNavs();
        
        //清空缓存
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
        //插入字段
        model('user/Datas','loglic')->insertField();
        
        //初始角色
        model('user/Datas','loglic')->insertRole();
        
        //初始权限
        model('user/Datas','loglic')->insertAuth();
        
        //后台菜单
        model('user/Datas','loglic')->insertMenu();
        
        //前台菜单（导航栏、侧边栏等）
        //model('user/Datas','loglic')->insertNavs();
        
        //更新版本
        \daicuo\Apply::updateStatus('user', 'enable');
        
        //清空缓存
        \think\Cache::clear();
        
        return true;
    }
    
    /**
    * 卸载时触发
    * @return bool 只有返回true时才会往下执行
    */
    public function remove()
    {
        return $this->unInstall();
    }
    
    /**
    * 删除时触发
    * @return bool 只有返回true时才会往下执行
    */
    public function unInstall()
    {
        return model('user/Datas','loglic')->unInstall();
	}
}