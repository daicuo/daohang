<?php
namespace app\daohang\validate;

use think\Validate;

class Info extends Validate
{
	
	protected $rule = [
        'info_name'     => 'require',
        'info_slug'     => 'require',
        'info_module'   => 'require',
        'info_id'       => 'require',
        'info_referer'  => 'require|url|unique_referer',
	];
	
	protected $message = [
		'info_name.require'    => '{%info_name_require}',
        'info_module.require'  => '{%info_module_require}',
        'info_id.require'      => '{%info_id_require}',
        'info_referer.require' => '{%dh_error_referer_require}',
        'info_referer.url'     => '{%dh_error_referer_url}',
	];
	
    //验证场景
	protected $scene = [
		'save'    =>  ['info_module','info_name','info_referer'],
		'update'  =>  ['info_module','info_name','info_referer','info_id'],
	];
    
    //网址是否收录
    protected function unique_referer($value, $rule, $data, $field)
    {
        //特殊网址
        if(in_array($value,['javascript:;','#'])){
            return true;
        }
        //查询数据库
        $where = array();
        $where['info_meta_key']   = ['eq','info_referer'];
        $where['info_meta_value'] = ['eq',$value];
        if($data['info_id']){
            $where['info_id'] = ['neq',$data['info_id']];
        }
        $info = db('infoMeta')->where($where)->value('info_meta_id');
        //无记录直接验证通过
        if(is_null($info)){
            return true;
        }
        //已有记录
		return lang('dh_error_referer_unique');
	}
}