<?php
namespace app\database\event;

use app\database\logic\Database as dbOper;

use think\Controller;

use think\Db;

class Transform extends Controller
{
	
    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        if(!is_writable('./apps/database.php')){
            $this->assign('error', '（./apps/database.php）没有写入权限、请先添加写入权限后再操作。');
        }
        return $this->fetch('database@transform/index');
    }
    
    //执行转换(先将sqlite备份然后导入到mysql)
    public function update()
    {
        //验证数据库类型
        if(config('database.type') == 'mysql'){
            $this->error('已经是MYSQL数据库！');
        }
        
        //数据库配置文件写入权限验证
        if(!is_writable('./apps/database.php')){
            $this->error('（./apps/database.php）没有写入权限。'); 
        }
        
        //转换配置
        $config = array(
            'path'     => './datas/sqlite2mysql/',//备份路径
            'part'     => '20971520',//分段大小
            'compress' => false,//是否压缩
            'level'    => 5,//压缩级别
            'connect'  => [],//新数据库连接参数
        );
        
        //实例化文件类
        $dir = new \files\Dir();
        
        //先删除失败的文件
        $dir->delDir($config['path']);
        
        //备份目录写入权限验证
        if (!is_dir($config['path'])) {
            if( !$dir->create($config['path'], 0755, true) ){
               $this->error($config['path'].'没有写入权限、请手动创建或给文件夹添加写入权限。'); 
            }
        }
        
        //MYSQL配置信息
        $data = [
            'type'      => 'mysql',
            'sn'        => '',
            'charset'   => 'utf8',
            'hostname'  => input('post.hostname/s', '127.0.0.1'),
            'database'  => input('post.database/s', 'daicuo'),
            'username'  => input('post.username/s', 'root'),
            'password'  => input('post.password/s', 'root'),
            'hostport'  => input('post.hostport/d', '3306'),
            'prefix'    => input('post.prefix/s', 'dc_'),
            'resultset_type'  => 'collection',
        ];

        // 验证MYSQL连接参数
        $connect = @mysqli_connect($data['hostname'].":".intval($data['hostport']), $data['username'], $data['password']);
        if($connect == false){
            $this->error('请检查主机地址/用户名/密码/端口');
        }
        // 数据库不存在,尝试建立
        if( !@mysqli_select_db($data['database']) ){
             //创建数据库语句
			 mysqli_query($connect, "CREATE DATABASE `".$data["database"]."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
            //数据库创建失败
            if( !@mysqli_select_db($connect, $data['database']) ){
                $this->error('MYSQL用户没有建立数据库的权限');
            }
        }
        //手动关闭MYSQL链接
        mysqli_close($connect);

        
        //生成备份文件信息
        $file = [
            'name' => date('Ymd-His', $this->request->time()),
            'part' => 1,
        ];
        //创建SQLITE备份文件类
        $database = new dbOper($file, $config);
        //写入初始数据验证写入权限
        if($database->create() !== false) {
            foreach(\think\Db::getTables() as $table){// 备份指定表
                if($table != 'sqlite_sequence'){//去除sqlite系统表
                    $start = $database->sqlite2mysql($table, 0);
                    while (0 !== $start) {
                        if (false === $start) {
                            return $this->error('备份出错');
                        }
                        $start = $database->sqlite2mysql($table, $start[0]);
                    }
                }
            }
        }
        //手动关闭文件操作
        $database->__destruct();
        
        //读取生成的备份文件并还原
        $files = $dir->listFile($config['path']);
        foreach($files as $value){
            $config = array_merge($config, ['connect'=>$data]);
            $result = $this->import($value['dirname'].'/'.$value['basename'], $config);
            if (false === $result) {
                return $this->error('恢复到MYSQL出错');
            }
        }
        
        //删除备份目录及子文件
        $dir->delDir($config['path']);
        
        //修改MYSQL连接配置
        write_array('./apps/database.php', $data);
        
        //转换完成
        $this->success(lang('success'));
    }
    
    //导入数据
    public function import($fileName, $config)
    {
        //文件信息
        $file = [
            'name' => $fileName,
        ];
        //导入第1行
        $database = new dbOper($file, $config);
        $start = $database->import(0);
        //导入所有数据
        while (0 !== $start) {
            if (false === $start) {
                return false;//数据恢复出错
            }
            $start = $database->import($start[0]);
        }
        return true;
    }
}