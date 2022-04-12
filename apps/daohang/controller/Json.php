<?php
namespace app\daohang\controller;

use app\common\controller\Api;

class Json extends Api
{
    // 权限认证
    protected $auth = [
         'check'       => false,
         'none_login'  => ['daohang/json/hits'],
         'none_right'  => [],
         'error_login' => 'daohang/json/index',
         'error_right' => '',
    ];
    
    public function _initialize()
    {
		parent::_initialize();
    }
    
    public function index()
    {
        $this->error(lang('empty'), ['value'=>0]);
    }
    
    public function hits()
    {
        return $this->incBase('info_hits');
    }
    
    public function views()
    {
        return $this->incBase('info_views');
    }
    
    public function up()
    {
        return $this->incMeta('info_up');
    }
    
    public function down()
    {
        return $this->incMeta('info_down');
    }
    
    //普通字段
    public function incBase($field='info_hits')
    {
        $id = input('id/f', 0);
        
        $this->safeCheck($id);

        $value = dbFindValue('common/Info', ['info_id'=>['eq',$id]], $field);
        
        if( !is_null($value) ){
        
            daohangInfoInc($id, $field);
            
            $this->success( lang('success'), ['value'=>intval($value)+1] );
        }
        
        $this->error(lang('empty'), ['value'=>0]);
    }
    
    //扩展字段
    private function incMeta($field='info_up')
    {
        $id = input('id/f', 0);
        
        $this->safeCheck($id);

        $value = dbFindValue('common/infoMeta', ['info_id'=>['eq',$id],'info_meta_key'=>['eq',$field]], 'info_meta_value');
        
        if( !is_null($value) ){
        
            daohangMetaInc($id, $field);
            
            $this->success( lang('success'), ['value'=>intval($value)+1] );
        }
        
        $this->error(lang('empty'), ['value'=>0]);
    }
    
    //防频繁刷新
    private function safeCheck($id=0)
    {
        if( !$id ){
            $this->error( lang('empty'), ['value'=>0], -1);
        }
        
        if( !input('server.HTTP_REFERER') ){
            $this->error( lang('empty'), ['value'=>0], -2);
        }
        
        if( !strpos(input('server.HTTP_REFERER'), input('server.HTTP_HOST')) ){
            $this->error( lang('empty'), ['value'=>0], -3);
        }
        
        //客户端唯一标识
        $client = md5('json'.$id.$this->site['action'].$this->request->ip().$this->request->header('user-agent'));
        //一小时内有效点击一次
        if( DcCache($client) ){
            $this->error( lang('dh_error_rest'), ['value'=>0], -4);
        }
        //缓存点击数
        DcCache($client, 1, 3600);
    }
}