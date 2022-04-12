<?php
namespace app\daohang\event;

class Sql
{
    /**
    * 安装时触发
    * @return bool 只有返回true时才会往下执行
    */
	public function install()
    {
        //配置
        model('daohang/Datas','loglic')->insertConfig();
        
        //路由
        model('daohang/Datas','loglic')->insertRoute();
        
        //权限
        model('daohang/Datas','loglic')->insertAuth();
        
        //字段
        model('daohang/Datas','loglic')->insertField();
        
        //后台菜单
        model('daohang/Datas','loglic')->insertMenu();
        
        //前台导航
        model('daohang/Datas','loglic')->insertNavs();
        
        //分类
        model('daohang/Datas','loglic')->insertCategory();
        
        //采集规则
        model('daohang/Datas','loglic')->insertCollect();
        
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
        //更新导航
        model('daohang/Datas','loglic')->updateNavs();
        //更新分类
        model('daohang/Datas','loglic')->updateCategory();
        //更新标签
        model('daohang/Datas','loglic')->updateTag();
        //扩展字段
        model('daohang/Datas','loglic')->insertField();
        //后台菜单
        model('daohang/Datas','loglic')->insertMenu();
        //采集规则
        model('daohang/Datas','loglic')->insertCollect();
        //更新基础信息
        \daicuo\Apply::updateStatus('daohang', 'enable');
        //更新打包配置
        if(config('common.apply_module') == 'daohang'){
            \daicuo\Op::write(['apply_version' => '1.4.9']);
        }
        //清空缓存
        \think\Cache::clear();
        //返回结果
        return true;
    }
    
    /**
    * 卸载插件时触发
    * @return bool 只有返回true时才会往下执行
    */
    public function remove()
    {
        \daicuo\Op::delete_module('daohang');
        
        model('common/Menu','loglic')->unInstall('daohang');
        
        model('common/Navs','loglic')->unInstall('daohang');
        
        return true;
    }
    
    /**
    * 删除插件时触发
    * @return bool 只有返回true时才会往下执行
    */
    public function unInstall()
    {
        //删除配置
        \daicuo\Op::delete_module('daohang');
        
        //删除队列
        for($i=0;$i<1000;$i++){
            model('daohang/Datas','loglic')->deleteTerm('uninstall');
        }
        
        //删除内容
        for($i=0;$i<1000;$i++){
            model('daohang/Datas','loglic')->deleteInfo('uninstall');
        }
        
        //返回结果
        return true;
	}
}