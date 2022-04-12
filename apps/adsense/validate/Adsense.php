<?php
namespace app\adsense\validate;

use think\Validate;

/*
**用于未格式化前的表单数据验证
*/
class Adsense extends Validate{
	
	protected $rule = [
        //'info_slug'        => 'require|unique_slug',
        'info_name'        => 'require',
        'info_module'      => 'require',
        'info_id'          => 'require',
	];
	
	protected $message = [
		'info_name.require'       => '{%info_name_require}',
        'info_module.require'     => '{%info_module_require}',
        'info_id.require'         => '{%info_id_require}',
	];
	
	//验证场景
	protected $scene = [
		'save'        =>  ['info_module','info_name'],
		'update'      =>  ['info_module','info_name','info_id'],
	];

}