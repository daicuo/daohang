<?php
namespace app\daohang\event;

use app\common\controller\Addon;

class Admin extends Addon
{
    public function _initialize()
    {
        parent::_initialize();
    }
    
    //定义表单字段列表
    protected function fields($data=[])
    {
        return model('daohang/Info','loglic')->fields($data);
    }
    
    //定义表单初始数据
    protected function formData()
    {
        if( $id = input('id/d',0) ){
            return daohangGet(['cache'=>false,'id'=>$id]);
		}
        return [];
    }
    
    //定义表格数据（JSON）
    protected function ajaxJson()
    {
        $args = array();
        $args['cache']     = false;
        $args['search']    = $this->query['searchText'];
        $args['limit']     = DcEmpty($this->query['pageSize'], 50);
        $args['page']      = DcEmpty($this->query['pageNumber'], 1);
        $args['sort']      = DcEmpty($this->query['sortName'], 'info_id');
        $args['order']     = DcEmpty($this->query['sortOrder'], 'desc');
        $args['action']    = $this->query['info_action'];
        $args['type']      = $this->query['info_type'];
        $args['status']    = $this->query['info_status'];
        $args['term_id']   = $this->query['category_id'];
        //按META字段条件筛选
        $args['meta_query']= daohangMetaQuery($this->query);
        //按META字段排序
        if( !in_array($args['sort'],['info_id','info_order','info_views','info_hits','info_create_time','info_update_time']) ){
            $args['meta_key'] = $args['sort'];
            $args['sort']     = 'meta_value_num';
        }
        /*按分类ID筛选
        if($this->query['category_id']){
            $args['term_id'] = ['in',DcTermSubIds($this->query['category_id'],'category','array')];
        }*/
        //查询数据
        $list = daohangSelect( DcArrayEmpty($args) );
        if( is_null($list) ){
            return [];
        }
        //拼装数据
        foreach($list['data'] as $key=>$value){
            $list['data'][$key]['category_names'] = implode(',',$value['category_name']);
            $list['data'][$key]['info_type_text'] = lang('dh_type_'.$value['info_type']);
        }
        return $list;
    }
    
    public function create()
    {
        $this->assign('fields', $this->formFields('create', $this->fields($this->query)));
        
        return $this->fetch('daohang@admin/create');
    }
    
    public function edit()
    {
        if( !$data=$this->formData() ){
            $this->error(lang('empty'));
        }
        
        $this->assign('data', $data);
        
        $this->assign('query', $this->query);
        
        $this->assign('fields', $this->formFields('edit', $this->fields($data)));
        
        return $this->fetch('daohang@admin/edit');
    }
    
    public function preview()
    {
        if( !$id = input('id/d',0) ){
            $this->error(lang('mustIn'));
        }
        //去掉后台入口文件
        $url = str_replace($this->request->baseFile(), '', daohangUrlInfo( daohangGet(['cache'=>false,'id'=>$id]) ) );
        //跳转至前台
        $this->redirect($url,302);
    }
    
    public function save()
    {

        if( !daohangSave(input('post.'), true) ){
            $this->error(\daicuo\Info::getError());
        }

        $this->success(lang('success'));
    }
    
    public function delete()
    {
        daohangDelete(input('id/a'));
        
        $this->success(lang('success'));
    }
    
    public function update()
    {
        if( !daohangUpdate(input('post.'), true) ){
            $this->error(\daicuo\Info::getError());
        }
        $this->success(lang('success'));
    }
    
    public function status()
    {
        if( !$ids = input('post.id/a') ){
            $this->error(lang('errorIds'));
        }
        //
        $data = [];
        $data['info_status'] = input('request.value/s', 'hidden');
        dbUpdate('common/Info',['info_id'=>['in',$ids]], $data);
        //
        $this->success(lang('success'));
    }
    
    public function type()
    {
        if( !$ids = input('post.id/a') ){
            $this->error(lang('errorIds'));
        }
        //
        $data = [];
        $data['info_type'] = input('request.value/s', 'index');
        dbUpdate('common/Info',['info_id'=>['in',$ids]], $data);
        //
        $this->success(lang('success'));
    }
}