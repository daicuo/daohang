<?php
namespace app\friend\event;

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
        $themes = DcThemeOption('friend');
    
        $items  = [
            'theme' => [
                'type'        =>'select', 
                'value'       => config('friend.theme'), 
                'option'      => $themes,
            ],
            'theme_wap' => [
                'type'        => 'select',
                'value'       => config('friend.theme_wap'),
                'option'      => $themes,
            ],
            'index_title'     => [
                'type'        => 'text',
                'value'       => config('friend.index_title'),
                'placeholder' => lang('friend_seo_tips'),
            ],
            'index_keywords'  => [
                'type'        => 'text',
                'value'       => config('friend.index_keywords'),
                'placeholder' => lang('friend_seo_tips'),
            ],
            'index_description' => [
                'type'        => 'text',
                'value'       => config('friend.index_description'),
                'placeholder' => lang('friend_seo_tips'),
            ],
            'publish_title'   => [
                'type'        => 'text',
                'value'       => config('friend.publish_title'),
                'placeholder' => lang('friend_seo_tips'),
            ],
            'publish_keywords'  => [
                'type'        => 'text',
                'value'       => config('friend.publish_keywords'),
                'placeholder' => lang('friend_seo_tips'),
            ],
            'publish_description'  => [
                'type'        => 'text',
                'value'       => config('friend.publish_description'),
                'placeholder' => lang('friend_seo_tips'),
            ],
        ];
        
        foreach($items as $key=>$value){
            $items[$key]['title']       = lang('friend_'.$key);
        }
        
        $this->assign('items', DcFormItems($items));
        
        return $this->fetch('friend@config/index');
	}
    
    public function update()
    {
        $status = \daicuo\Op::write(input('post.'), 'friend', 'config', 'system', 0, 'yes');
		if(!$status){
		    $this->error(lang('fail'));
        }
        //返回结果
        $this->success(lang('success'));
	}
    
}