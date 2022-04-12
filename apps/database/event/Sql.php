<?php
namespace app\database\event;

class Sql
{
    /**
    * 安装时触发/通常用于数据库操作或调用接口
    * @return bool 只有返回true时才会往下执行
    */
	public function install()
    {
        $this->insertMenu();
        
        return true;
	}
    
    /**
    * 升级时触发/通常用于数据库操作
    * @return bool 只有返回true时才会往下执行
    */
    public function upgrade()
    {
        $this->insertMenu();
        
        \daicuo\Apply::updateStatus('database', 'enable');
        
        return true;
    }
    
    /**
    * 卸载插件时触发/通常用于数据库操作
    * @return bool 只有返回true时才会往下执行
    */
    public function remove()
    {
        $this->unInstall();
        
        return true;
    }
    
    /**
    * 删除插件时触发/通常用于数据库操作
    * @return bool 只有返回true时才会往下执行
    */
    public function unInstall()
    {
        model('common/Menu','loglic')->unInstall('database');
        
        return true;
	}
    
    //批量插入后台菜单
    private function insertMenu()
    {
        $result = model('common/Menu','loglic')->install([
            [
                'term_name'   => '数据库',
                'term_slug'   => 'database',
                'term_info'   => 'fa-database',
                'term_module' => 'database',
            ],
        ]);
        
        $result = model('common/Menu','loglic')->install([
            [
                'term_name'   => '数据库管理',
                'term_slug'   => 'database/admin/index',
                'term_info'   => 'fa-paw',
                'term_module' => 'database',
                'term_order'  => 9,
            ],
            [
                'term_name'   => '数据库还原',
                'term_slug'   => 'database/import/index',
                'term_info'   => 'fa-wrench',
                'term_module' => 'database',
                'term_order'  => 8,
            ],
            [
                'term_name'   => '数据库转换',
                'term_slug'   => 'database/transform/index',
                'term_info'   => 'fa-send',
                'term_module' => 'database',
                'term_order'  => 7,
            ],
            [
                'term_name'   => '执行SQL',
                'term_slug'   => 'database/execute/index',
                'term_info'   => 'fa-code',
                'term_module' => 'database',
                'term_order'  => 6,
            ],
        ],'数据库');
    }
	
}