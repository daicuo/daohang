<?php
namespace app\friend\validate;

use think\Validate;

class Common extends Validate
{
	
	protected $rule = [
        'info_module'    => 'require',
        'info_name'      => 'require',
        'info_id'        => 'require',
        'friend_referer' => 'require|url',
	];
	
	protected $message = [
        'info_module.require'    => '{%friend_module_require}',
		'info_name.require'      => '{%friend_name_require}',      
        'info_id.require'        => '{%friend_id_require}',
        'friend_referer.require' => '{%friend_referer_require}',
        'friend_referer.url'     => '{%friend_referer_url}',
	];
	
	protected $scene = [
        //新增
		'save' => ['info_module','info_name','friend_referer'],
        //修改
		'update' => ['info_module','info_name','info_id'],
	];
    
}