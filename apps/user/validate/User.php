<?php
namespace app\user\validate;

use think\Validate;

class User extends Validate{
	
	protected $rule = [
        'user_pass'         =>  'require',
        'user_pass_confirm' =>  'require|confirm:user_pass',
        'user_pass_old'     =>  'require',
	];
	
	protected $message = [
        'user_pass.require'         => '{%user_pass_require}',
        'user_pass_confirm.require' => '{%user_pass_confirm_require}',
		'user_pass_confirm.confirm' => '{%user_pass_confirm_confirm}',
        'user_pass_old.require'     => '{%user_pass_old_require}',
	];
	
	protected $scene = [
        'repwd'     =>  ['user_pass','user_pass_confirm','user_pass_old'],
	];
}