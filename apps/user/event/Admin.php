<?php
namespace app\user\event;

use think\Controller;

class Admin extends Controller
{
	
	public function _initialize()
    {
		parent::_initialize();
	}

	public function index()
    {
        $items = [
            'theme'                => ['type'=>'select', 'value'=>config('user.theme'), 'option'=>DcThemeOption('user')],
            'theme_wap'            => ['type'=>'select', 'value'=>config('user.theme_wap'),'option'=>DcThemeOption('user')],
            'register_name'        => ['type'=>'custom', 'value'=>config('user.register_name'),'option'=>[true=>lang('open'),false=>lang('close')]],
            'register_email'       => ['type'=>'custom', 'value'=>config('user.register_email'),'option'=>[true=>lang('open'),false=>lang('close')]],
            'register_mobile'      => ['type'=>'custom', 'value'=>config('user.register_mobile'),'option'=>[true=>lang('open'),false=>lang('close')]],
            'title_login'          => ['type'=>'text', 'value'=>config('user.title_login')],
            'keywords_login'       => ['type'=>'text', 'value'=>config('user.keywords_login')],
            'description_login'    => ['type'=>'text', 'value'=>config('user.description_login')],
            'title_register'       => ['type'=>'text', 'value'=>config('user.title_login')],
            'keywords_register'    => ['type'=>'text', 'value'=>config('user.keywords_login')],
            'description_register' => ['type'=>'text', 'value'=>config('user.description_login')],
            'callback_secret'      => ['type'=>'text', 'value'=>config('user.callback_secret')],
            'callback_domains'     => ['type'=>'textarea', 'value'=>config('user.callback_domains'), 'rows'=>5],
        ];
        
        foreach($items as $key=>$value){
            $items[$key]['title']  = lang('user_'.$key);
            if(!isset($value['placeholder'])){
                $items[$key]['placeholder'] = lang('user_'.$key.'_placeholder');
            }
        }
        
        $this->assign('items', DcFormItems($items));
        
        return $this->fetch('user@admin/index');
	}
    
    public function update()
    {
        $status = \daicuo\Op::write(input('post.'),'user', 'config','system',0,'yes');
		if( !$status ){
		    $this->error(lang('fail'));
        }
        $this->success(lang('success'));
	}
}