<?php
namespace app\daohang\event;

use think\Controller;

class Config extends Controller
{
	
    public function _initialize()
    {
        $this->query = $this->request->param();
        
        parent::_initialize();
    }

	public function index()
    {
        $themes = DcThemeOption('daohang');
    
        $items  = [
            'theme' => [
                'type'        =>'select', 
                'value'       => config('daohang.theme'), 
                'option'      => $themes,
                'tips'        => lang('dh_theme_placeholder'),
            ],
            'theme_wap' => [
                'type'        => 'select',
                'value'       => config('daohang.theme_wap'),
                'option'      => $themes,
                'tips'        => lang('dh_theme_wap_placeholder'),
            ],
            'slug_first' => [
                'type'        => 'select',
                'value'       => config('daohang.slug_first'),
                'option'      => [0=>lang('close'),1=>lang('open')],
                'tips'        => lang('dh_slug_first_placeholder'),
            ],
            'jump_page' => [
                'type'        => 'select',
                'value'       => config('daohang.jump_page'),
                'option'      => [0=>lang('close'),1=>lang('open')],
                'tips'        => lang('dh_jump_page_placeholder'),
            ],
            'publish_save' => [
                'type'        => 'select',
                'value'       => config('daohang.publish_save'),
                'option'      => ['off'=>lang('close'),'on'=>lang('open')],
                'tips'        => lang('dh_publish_save_placeholder'),
            ],
            'score_fast' => [
                'type'        => 'number',
                'value'       => intval(config('daohang.score_fast')),
            ],
            'request_max' => [
                'type'        => 'number',
                'value'       => intval(config('daohang.request_max')),
            ],
            'search_interval' => [
                'type'        => 'number',
                'value'       => intval(config('daohang.search_interval')),
            ],
            'search_hot' => [
                'type'        => 'text',
                'value'       => config('daohang.search_hot'),
            ],
            'search_list' => [
                'type'        => 'text',
                'value'       => config('daohang.search_list'),
                'rows'        => 5,
            ],
            'label_strip' => [
                'type'        => 'text',
                'value'       => config('daohang.label_strip'),
            ],
            'post_pwd' => [
                'type'        => 'text',
                'value'       => config('daohang.post_pwd'),
            ],
            'hr_1' => [
                'type'        => 'html',
                'value'       => '<hr>',
            ],
            'page_size' => [
                'type'        => 'number',
                'value'       => intval(config('daohang.page_size')),
            ],
            'page_max' => [
                'type'        => 'number',
                'value'       => DcEmpty(config('daohang.page_max'),100),
            ],
            'limit_search' => [
                'type'        => 'number',
                'value'       => intval(config('daohang.limit_search')),
            ],
            'limit_sitemap' => [
                'type'        => 'number',
                'value'       => intval(config('daohang.limit_sitemap')),
            ],
            'limit_index_web' => [
                'type'        => 'number',
                'value'       => intval(config('daohang.limit_index_web')),
                'placeholder' => lang('dh_limit_index_placeholder'),
            ],
            'limit_index_category' => [
                'type'        => 'number',
                'value'       => intval(config('daohang.limit_index_category')),
                'placeholder' => lang('dh_limit_index_placeholder'),
            ],
            'limit_index_tag' => [
                'type'        => 'number',
                'value'       => intval(config('daohang.limit_index_tag')),
                'placeholder' => lang('dh_limit_index_placeholder'),
            ],
            'limit_index_hot' => [
                'type'        => 'number',
                'value'       => intval(config('daohang.limit_index_hot')),
                'placeholder' => lang('dh_limit_index_placeholder'),
            ],
            'hr_2' => [
                'type'        => 'html',
                'value'       => '<hr>',
            ],
            'type_option' => [
                'type'        => 'json',
                'value'       => DcEmpty(config('daohang.type_option'),json_encode(['index'=>'标准'])),
                'rows'        => 5,
            ],
        ];
        
        foreach($items as $key=>$value){
            $items[$key]['title']       = lang('dh_'.$key);
            if(!isset($value['placeholder'])){
                $items[$key]['placeholder'] = lang('dh_'.$key.'_placeholder');
            }
        }
        
        $this->assign('items', DcFormItems($items));
        
        return $this->fetch('daohang@config/index');
	}
    
    public function update()
    {
        $status = daohangConfigSave(input('post.'));
		if(!$status){
		    $this->error(lang('fail'));
        }
        //返回结果
        $this->success(lang('success'));
	}
}