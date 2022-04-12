<?php
namespace app\database\logic;

use think\Db;

//数据库操作模型
class Database {
    /**
     * 文件指针
     * @var resource
     */
    private $fp;

    /**
     * 备份文件信息 part - 卷号，name - 文件名
     * @var array
     */
    private $file;

    /**
     * 当前打开文件大小
     * @var integer
     */
    private $size = 0;

    /**
     * 备份配置
     * @var integer
     */
    private $config;

    /**
     * 数据库备份构造方法
     * @param array  $file   备份或还原的文件信息
     * @param array  $config 备份配置信息
     * @param string $type   执行类型，export - 备份数据， import - 还原数据
     */
    public function __construct($file, $config, $type = 'export'){
        $this->file   = $file;
        $this->config = $config;
    }

    /**
     * 打开一个卷，用于写入数据
     * @param  integer $size 写入数据的大小
     */
    private function open($size){
        if($this->fp){
            $this->size += $size;
            if($this->size > $this->config['part']){
                $this->config['compress'] ? @gzclose($this->fp) : @fclose($this->fp);
                $this->fp = null;
                $this->file['part']++;
                session('backup_file', $this->file);
                $this->create();
            }
        } else {
            $backuppath = $this->config['path'];
            $filename   = "{$backuppath}{$this->file['name']}-{$this->file['part']}.sql";
            if($this->config['compress']){
                $filename = "{$filename}.gz";
                $this->fp = @gzopen($filename, "a{$this->config['level']}");
            } else {
                $this->fp = @fopen($filename, 'a');
            }
            $this->size = filesize($filename) + $size;
        }
    }

    /**
     * 写入初始数据
     * @return boolean true - 写入成功，false - 写入失败
     */
    public function create(){
        $sql  = "-- -----------------------------\n";
        $sql .= "-- Think MySQL Data Transfer \n";
        $sql .= "-- \n";
        $sql .= "-- Host     : " . config('database.hostname') . "\n";
        $sql .= "-- Port     : " . config('database.hostport') . "\n";
        $sql .= "-- Database : " . config('database.database') . "\n";
        $sql .= "-- \n";
        $sql .= "-- Part : #{$this->file['part']}\n";
        $sql .= "-- Date : " . date("Y-m-d H:i:s") . "\n";
        $sql .= "-- -----------------------------\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";
        return $this->write($sql);
    }

    /**
     * 写入SQL语句
     * @param  string $sql 要写入的SQL语句
     * @return boolean     true - 写入成功，false - 写入失败！
     */
    private function write($sql){
    
        $size = strlen($sql);
        
        //一般情况压缩率都会高于50%；
        $size = $this->config['compress'] ? $size / 2 : $size;
        
        $this->open($size);
        
        return $this->config['compress'] ? @gzwrite($this->fp, $sql) : @fwrite($this->fp, $sql);
    }

    /**
     * 备份表结构与数据
     * @param  string  $table 表名
     * @param  integer $start 起始行数
     * @return boolean        false - 备份失败
     */
    public function backup($table, $start){
    
        //备份表结构
        if(0 == $start){
            $result = Db::query("SHOW CREATE TABLE `{$table}`");
            $sql  = "\n";
            $sql .= "-- -----------------------------\n";
            $sql .= "-- Table structure for `{$table}`\n";
            $sql .= "-- -----------------------------\n";
            $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $sql .= trim($result[0]['Create Table']) . ";\n\n";
            if(false === $this->write($sql)){
                return false;
            }
        }

        //数据总数
        $result = Db::query("SELECT COUNT(*) AS count FROM `{$table}`");
        $count  = $result['0']['count'];
            
        //备份表数据
        if($count){
            //写入数据注释
            if(0 == $start){
                $sql  = "-- -----------------------------\n";
                $sql .= "-- Records of `{$table}`\n";
                $sql .= "-- -----------------------------\n";
                $this->write($sql);
            }

            //备份数据记录
            $result = Db::query("SELECT * FROM `{$table}` LIMIT {$start}, 1000");

            foreach ($result as $row) {
                $row = array_map('htmlspecialchars_decode', $row);
                $row = array_map('addslashes', $row);
                $sql = "INSERT INTO `{$table}` VALUES ('" . implode("', '", $row) . "');\n";
                if(false === $this->write($sql)){
                    return false;
                }
            }

            //还有更多数据
            if($count > $start + 1000){
                return array($start + 1000, $count);
            }
        }

        //备份下一表
        return 0;
    }
    
    /**
     * 导入数据
     * @param integer $start 起始行数
     * @return boolean false - 备份失败
     */
    public function import($start){
    
        //还原数据
        if($this->config['compress']){
            $gz   = gzopen($this->file['name'], 'r');
            $size = 0;
        } else {
            $size = filesize($this->file['name']);
            $gz   = fopen($this->file['name'], 'r');
        }
        
        //断点位置
        $sql = '';
        if($start){
            $this->config['compress'] ? gzseek($gz, $start) : fseek($gz, $start);
        }
        
        for($i = 0; $i < 1000; $i++){
        
            $sql .= $this->config['compress'] ? gzgets($gz) : fgets($gz);
            
            if(preg_match('/.*;$/', trim($sql))){
                //执行SQL语句
                if($this->config['connect']){
                    $result = Db::connect($this->config['connect'])->query($sql);
                }else{
                    $result = Db::query($sql);
                }
                //返回恢复到的文件指针位置
                if(false !== $result){
                    $start += strlen($sql);
                } else {
                    return false;
                }
                $sql = '';
            } elseif ($this->config['compress'] ? gzeof($gz) : feof($gz)) {
                return 0;
            }
        }

        return array($start, $size);
    }
    
    /**
     * sqlite转mysql语句
     * @param  string  $table 表名
     * @param  integer $start 起始行数
     * @return boolean        false - 备份失败
     */
    public function sqlite2mysql($table, $start){
        $result = Db::query("select * from sqlite_master");
        //备份表结构
        if(0 == $start){
            //生成建表语句列表
            $result = Db::query("select * from sqlite_master where type = 'table' and name = '".$table."'");
            //建表语句处理
            if($result[0]['sql']){
                $sql_create = str_replace("	", " ", $result[0]['sql']);//全角空格
                $sql_create = str_replace(['[',']','"','`'],'',$sql_create);//统一去掉转义标识
                $sql_create = str_replace(['AUTOINCREMENT','TEXT','INTEGER'],['AUTO_INCREMENT','LONGTEXT','BIGINT(20)'],$sql_create);//类型转换
                $sql_create = str_replace('AUTO_INCREMENT)',')',$sql_create);//PRIMARY KEY(term_id AUTO_INCREMENT)需要过滤掉
            }
            $sql  = "\n";
            $sql .= "-- -----------------------------\n";
            $sql .= "-- Table structure for `{$table}`\n";
            $sql .= "-- -----------------------------\n";
            $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $sql .= trim($sql_create) . "ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;\n";
            
            //生成索引语句列表
            $index = Db::query("select * from sqlite_master where type = 'index' and tbl_name = '".$table."'");
            //索引语句处理
            foreach($index as $key=>$value){
                if($value['sql']){
                    $sql .= str_replace(['[',']','"','`'], '', trim($value['sql'])) . ";\n";
                }
            }
            //还原不需要转换的字段
            $sql = str_replace('info_excerpt LONGTEXT', 'info_excerpt TEXT', $sql);
            $sql = str_replace('term_count BIGINT(20)', 'term_count INT(11)', $sql);
            $sql = str_replace('create_time BIGINT(20)', 'create_time INT(11)', $sql);
            $sql = str_replace('update_time BIGINT(20)', 'update_time INT(11)', $sql);
            $sql = str_replace('order BIGINT(20)', 'order INT(11)', $sql);
            //生成语句
            if(false === $this->write($sql)){
                return false;
            }
        }

        //数据总数
        $result = Db::query("SELECT COUNT(*) AS count FROM `{$table}`");
        $count  = $result['0']['count'];
            
        //备份表数据
        if($count){
            //写入数据注释
            if(0 == $start){
                $sql  = "-- -----------------------------\n";
                $sql .= "-- Records of `{$table}`\n";
                $sql .= "-- -----------------------------\n";
                $this->write($sql);
            }

            //备份数据记录
            $result = Db::query("SELECT * FROM `{$table}` LIMIT {$start}, 1000");
            foreach ($result as $row) {
                $row = array_map('htmlspecialchars_decode', $row);
                $row = array_map('addslashes', $row);
                $sql = "INSERT INTO `{$table}` (`".implode("`, `",array_keys($row))."`) VALUES ('" . implode("', '", $row) . "');\n";
                if(false === $this->write($sql)){
                    return false;
                }
            }

            //还有更多数据
            if($count > $start + 1000){
                return array($start + 1000, $count);
            }
        }

        //备份下一表
        return 0;
    }
    
    // 去掉连续空白
    private function nb($str){
        return preg_replace('#\s+#', ' ',trim($str));
    }

    /**
     * 析构方法，用于关闭文件资源
     */
    public function __destruct(){
        $this->config['compress'] ? @gzclose($this->fp) : @fclose($this->fp);
    }
}