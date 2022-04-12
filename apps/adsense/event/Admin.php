<?php
namespace app\adsense\event;

use app\common\controller\Addon;

class Admin extends Addon
{
	
	public function _initialize()
    {
		parent::_initialize();
	}
    
    //定义表格数据（JSON）
    protected function ajaxJson()
    {
        $args = array();
        $args['cache']    = false;
        $args['search']   = $this->query['searchText'];
        $args['limit']    = 0;
        $args['page']     = 0;
        $args['sort']     = DcEmpty($this->query['sortName'], 'info_id');
        $args['order']    = DcEmpty($this->query['sortOrder'], 'desc');
        $args['module']   = $this->query['info_module'];
        $args['controll'] = $this->query['info_controll'];
        $args['action']   = $this->query['info_action'];
        $args['type']     = $this->query['info_type'];
        $args['status']   = $this->query['info_status'];
        //查询数据
        $item = adsenseAll(DcArrayEmpty($args));
        if( is_null($item) ){
            return [];
        }
        //操作管理
        foreach($item as $key=>$value){
            $item[$key]['info_operates'] = adsenseOperate($value);
        }
        return $item;
    }
    
    public function create()
    {
        return $this->fetch('adsense@admin/create');
	}
    
    public function save()
    {
        if( !$infoId = adsenseSave(input('post.')) ){
            $this->error(config('daicuo.error'));
        }
        $this->success(lang('success'));
	}
    
    public function delete()
    {
        $ids = input('id/a');
		if(!$ids){
			$this->error(lang('mustIn'));
		}
        adsenseDelete($ids);
        $this->success(lang('success'));
    }
    
    public function edit()
    {
        $info_id = input('id/d',0);
		if(!$info_id){
			$this->error(lang('mustIn'));
		}
		//查询数据
        $data = adsenseGetId($info_id, false);
        if( is_null($data) ){
            $this->error(lang('empty'));
        }
		$this->assign('data', $data);
        return $this->fetch('adsense@admin/edit');
    }
    
    public function update()
    {
        if( !$info = adsenseUpdate(input('post.')) ){
            $this->error(config('daicuo.error'));
        }
        $this->success(lang('success'));
	}
    
    public function token()
    {
        //是否设置框架平台的ID与TOKEN
        if(!config("common.site_id") || !config("common.site_token")){
            $this->error('您还没有填写呆错框架平台的渠道与令牌','http://hao.daicuo.cc/1.4/token/');
        }
        //换取登录后台的密钥
        $array = [];
        $array['id'] = config("common.site_id");
        $array['token'] = config("common.site_token");
        $sercet = DcCurl('auto', 3, 'http://hao.daicuo.cc/adsense/sercet/',$array);
        //跳转充值联盟后台管理
        $this->redirect('https://hao.daicuo.cc/adsense/admin/?sercet='.$sercet, 302);
    }
	
}