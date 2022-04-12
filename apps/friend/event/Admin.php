<?php
namespace app\friend\event;

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
        return model('friend/Common','loglic')->fields($data);
    }
    
    //定义表单初始数据
    protected function formData()
    {
        if( $id = input('id/d',0) ){
            return friendGet([
                'cache'  => false,
                'status' => '',
                'id'     => $id,
            ]);
		}
        return [];
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
        $args['module']   = 'friend';
        $args['status']   = $this->query['info_status'];
        //自定义字段排序
        if( !in_array($args['sort'],['info_id','info_order','info_views','info_hits','info_create_time','info_update_time']) ){
            $args['meta_key'] = $args['sort'];
            $args['sort']     = 'meta_value_num';
        }
        //查询数据
        $list = friendSelect( DcArrayEmpty($args) );
        //数据返回
        return DcEmpty($list,[]);
    }
    
    public function save()
    {

        if( !friendSave(input('post.')) ){
            $this->error(\daicuo\Info::getError());
        }
        
        $this->success(lang('success'));
    }
    
    public function delete()
    {
        friendDelete(input('id/a'));
        
        $this->success(lang('success'));
    }
    
    public function update()
    {
        if( !friendUpdate(input('post.')) ){
            $this->error(\daicuo\Info::getError());
        }
        $this->success(lang('success'));
    }
    
    public function preview()
    {
        if( !$id = input('id/d',0) ){
            $this->error(lang('errorIds'));
        }
        $data = friendGet([
            'cache'  => false,
            'status' => '',
            'id'     => $id,
        ]);
        //去掉后台入口文件
        $url = str_replace($this->request->baseFile(), '', friendUrl($data['info_referer']) );
        //跳转至前台
        $this->redirect($url, 302);
    }
    
    public function status()
    {
        if( !$ids = input('post.id/a') ){
            $this->error(lang('errorIds'));
        }
        //批量更新状态
        $data = [];
        $data['info_status'] = input('request.value/s', 'hidden');
        dbUpdate('common/Info',['info_id'=>['in',$ids]], $data);
        //返回结果
        $this->success(lang('success'));
    }
}