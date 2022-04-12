<?php
namespace app\daohang\validate;

use think\Validate;

class Tag extends Validate
{
	protected $rule = [
		'term_name'        => 'require|unique',
        'term_id'          => 'require',
	];
	
	protected $message = [
		'term_name.require' => '{%term_name_require}',
	];
	
	protected $scene = [
		'save'              =>  ['term_name'],
		'update'            =>  ['term_name'],
	];
    
    protected function unique($value, $rule, $data, $field)
    {
        $where = [];
        $where['term_controll'] = 'tag';
        $where['term_module']   = 'daohang';
        $where['term_name']     = $value;
        if($data['term_id']){
            $where['term_id']   = ['neq',$data['term_id']];
        }
        $info = db('term')->where($where)->value('term_id');
        //无记录直接验证通过
        if(is_null($info)){
            return true;
        }
        return lang('dh_error_term_unique');
	}
}