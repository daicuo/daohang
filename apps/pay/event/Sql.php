<?php
namespace app\pay\event;

class Sql
{
    /**
    * 安装时触发
    * @return bool 只有返回true时才会往下执行
    */
	public function install()
    {
        $this->installSql();
        
        $this->insertMenu();
        
        return true;
	}
    
    /**
    * 升级时触发
    * @return bool 只有返回true时才会往下执行
    */
    public function upgrade()
    {
        $this->insertMenu();
        
        \daicuo\Apply::updateStatus('pay', 'enable');
        
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
        $this->deleteSql();
        
        return true;
	}
	
    //建表语句
    protected function installSql()
    {
        $sql = [];
        
        $prefix = config('database.prefix');
        
        if(config('database.type') == 'mysql'){
            //删除已建表
            array_push($sql,"DROP TABLE IF EXISTS `".$prefix."pay`;");
            //建表语句
            array_push($sql, "CREATE TABLE `".$prefix."pay` (
              `pay_id` bigint(20) NOT NULL,
              `pay_sign` varchar(32) NOT NULL COMMENT '订单号',
              `pay_number` varchar(64) DEFAULT NULL COMMENT '支付平台流水号',
              `pay_info_id` bigint(20) NOT NULL DEFAULT '1' COMMENT '商品ID',
              `pay_user_id` bigint(20) NOT NULL DEFAULT '1' COMMENT '购买用户',
              `pay_price` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '单价',
              `pay_quantity` mediumint(8) NOT NULL DEFAULT '1' COMMENT '购买数量',
              `pay_total_fee` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '总金额',
              `pay_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '交易状态',
              `pay_module` varchar(100) NOT NULL DEFAULT 'user' COMMENT '应用名称',
              `pay_controll` varchar(100) NOT NULL DEFAULT 'recharge' COMMENT '应用操作',
              `pay_action` varchar(100) NOT NULL DEFAULT 'save' COMMENT '业务类型',
              `pay_scene` varchar(100) NOT NULL DEFAULT 'pc' COMMENT '支付场景',
              `pay_platform` varchar(100) DEFAULT NULL COMMENT '付款平台',
              `pay_platform_status` varchar(100) NOT NULL DEFAULT '-' COMMENT '平台交易状态',
              `pay_name` varchar(200) NOT NULL COMMENT '订单名称',
              `pay_content` tinytext COMMENT '订单说明',
              `pay_create_time` int(11) NOT NULL DEFAULT '1639322269',
              `pay_update_time` int(11) NOT NULL DEFAULT '1639322269'
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
            //索引
            array_push($sql, "ALTER TABLE `".$prefix."pay`
              ADD PRIMARY KEY (`pay_id`),
              ADD KEY `pay_sign` (`pay_sign`),
              ADD KEY `pay_number` (`pay_number`),
              ADD KEY `pay_status` (`pay_status`);");
            //递增
            array_push($sql, "ALTER TABLE `".$prefix."pay`
              MODIFY `pay_id` bigint(20) NOT NULL AUTO_INCREMENT;");
        }else{
            //删除已建表
            array_push($sql, "DROP TABLE IF EXISTS dc_pay;");
            //建表语句
            array_push($sql, "CREATE TABLE [dc_pay] (
                [pay_id] INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                [pay_sign] VARCHAR(32) NULL,
                [pay_number] VARCHAR(64) NULL,
                [pay_user_id] INTEGER DEFAULT '0' NULL,
                [pay_info_id] INTEGER DEFAULT '0' NULL,
                [pay_price] DECIMAL(18,2) DEFAULT '0.00' NULL,
                [pay_quantity] INTEGER DEFAULT '1' NULL,
                [pay_total_fee] DECIMAL(18,2) DEFAULT '0.00' NULL,
                [pay_status] INTEGER DEFAULT '1' NULL,
                [pay_module] VARCHAR(100) DEFAULT 'pay' NULL,
                [pay_controll] VARCHAR(100) DEFAULT 'recharge' NULL,
                [pay_action] VARCHAR(100) DEFAULT 'save' NULL,
                [pay_scene] VARCHAR(100) DEFAULT 'pc' NULL,
                [pay_platform] VARCHAR(100) NULL,
                [pay_platform_status] VARCHAR(100) NULL,
                [pay_name] VARCHAR(255) DEFAULT '-' NULL,
                [pay_content] TEXT NULL,
                [pay_create_time] INTEGER DEFAULT '1639322269' NULL,
                [pay_update_time] INTEGER DEFAULT '1639322269' NULL
            );");
            //索引语句
            array_push($sql,"CREATE INDEX [pay_id] ON [dc_pay](pay_id);");
            array_push($sql,"CREATE INDEX [pay_sign] ON [dc_pay](pay_sign);");
            array_push($sql,"CREATE INDEX [pay_number] ON [dc_pay](pay_number);");
            array_push($sql,"CREATE INDEX [pay_status] ON [dc_pay](pay_status);");
        }
        
        //执行语句
        foreach($sql as $key=>$value){
            \think\Db::execute($value); 
        }
    }
    
    //删除数据表
    protected function deleteSql()
    {
        \daicuo\Op::delete_module('pay');
        
        \think\Db::execute("DROP TABLE IF EXISTS `dc_pay`;");
    }
    
    //创建后台菜单
    private function insertMenu()
    {
        model('common/Menu','loglic')->unInstall('pay');
        
        $result = model('common/Menu','loglic')->install([
            [
                'term_name'   => '支付',
                'term_slug'   => 'pay',
                'term_info'   => 'fa-cc-visa',
                'term_module' => 'pay',
            ],
        ]);
        
        $result = model('common/Menu','loglic')->install([
            [
                'term_name'   => '支付设置',
                'term_slug'   => 'pay/config/index',
                'term_info'   => 'fa-gear',
                'term_module' => 'pay',
                'term_order'  => 9,
            ],
            [
                'term_name'   => '订单管理',
                'term_slug'   => 'pay/admin/index',
                'term_info'   => 'fa-paypal',
                'term_module' => 'pay',
                'term_order'  => 1,
            ],
        ],'支付');
    }
}