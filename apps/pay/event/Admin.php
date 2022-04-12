<?php
namespace app\pay\event;

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
        return model('pay/Common','loglic')->fields($data);
    }
    
    //定义表单初始数据
    protected function formData()
    {
        if( $id = input('id/d',0) ){
            return model('pay/Common','loglic')->get([
                'cache' => false,
                'where' => ['pay_id'=>['eq',$id]],
            ]);
		}
        return [];
    }

    //定义表格数据（JSON）
    protected function ajaxJson()
    {
        //查询参数
        $args = array();
        $args['with']     = ''; 
        $args['cache']    = false;
        $args['limit']    = input('pageSize/d', 50);
        $args['page']     = input('pageNumber/d', 1);
        $args['sort']     = input('sortName/s','pay_id');
        $args['order']    = input('sortOrder/s','desc');
        $args['search']   = input('searchText/s','');
        if( $where = DcWhereQuery(['pay_sign','pay_number','pay_user_id','pay_info_id','pay_status','pay_module','pay_controll','pay_action','pay_scene','pay_platform'], 'eq', $this->query) ){
            $args['where'] = $where;
        }
        if( $this->query['searchText'] ){
            $args['where']['pay_name|pay_sign|pay_number|pay_content'] = ['like','%'.DcHtml($this->query['searchText'].'%')];
        }
        //数据查询
        $list = model('pay/Common','loglic')->all($args);
        //数据返回
        return DcEmpty($list,['total'=>0,'data'=>[]]);
    }
    
    //删除(数据库)
	public function delete()
    {
		$ids = input('id/a');
		if(!$ids){
			$this->error(lang('errorIds'));
		}
        //
        dbDelete('pay/Pay',['pay_id'=>['in',$ids]]);
        $this->success(lang('success'));
	}
    
    //修改（数据库）
	public function update()
    {
		$post = input('post.');
        if(!$post['pay_id']){
            $this->error(lang('errorIds'));
        }
        if($post['pay_create_time']){
            $post['pay_create_time'] = strtotime($post['pay_create_time']);
        }else{
            $post['pay_create_time'] = time();
        }
        if($post['pay_update_time']){
            $post['pay_update_time'] = strtotime($post['pay_update_time']);
        }else{
            $post['pay_update_time'] = time();
        }
        //
        $info = model('pay/Common','loglic')->updateId($post['pay_id'], $post);
        if(is_null($info)){
            $this->error(model('pay/Common','loglic')->getError());
        }
        $this->success(lang('success'));
	}
}