<?php
namespace app\daohang\event;

use think\Controller;

class Seo extends Controller
{
    public function _initialize()
    {
        $this->query = $this->request->param();
        
        parent::_initialize();
    }
    
    public function index()
    {
        $items = [
            'rewrite_index' => [
                'type'        => 'text', 
                'value'       => DcEmpty(config('daohang.rewrite_index'), 'daohang$'),
                'placeholder' => lang('dh_rewrite_index_placeholder'),
                'tips'        => 'daohang$',
            ],
            'rewrite_category' => [
                'type'        => 'text', 
                'value'       => config('daohang.rewrite_category'),
                'placeholder' => '',
                'tips'        => '[:id] [:slug] [:name] [:pageNumber]',
            ],
            'rewrite_tag' => [
                'type'        => 'text',
                'value'       => config('daohang.rewrite_tag'),
                'placeholder' => '',
                'tips'        => '[:id] [:slug] [:name] [:pageNumber]',
            ],
            'rewrite_search' => [
                'type'        => 'text',
                'value'       => config('daohang.rewrite_search'),
                'placeholder' => '',
                'tips'        => '[:searchText] [:pageNumber] [:pageSize]',
            ],
            'rewrite_filter' => [
                'type'        => 'text',
                'value'       => config('daohang.rewrite_filter'),
                'placeholder' => '',
                'tips'        => '[:termId] [:termSlug] [:termName] [:pageNumber] [:pageSize] [:sortName] [:sortNumber]',
            ],
            'rewrite_detail' => [
                'type'        => 'text',
                'value'       => config('daohang.rewrite_detail'),
                'placeholder' => '',
                'tips'        => '[:id] [:slug] [:name] [:termId] [:termSlug] [:termName]',
            ],
            'html_hr' => [
                'type'        => 'html',
                'value'       => '<hr>',
            ],
            'index_title'                => ['type'=>'text', 'value'=>config('daohang.index_title')],
            'index_keywords'             => ['type'=>'text', 'value'=>config('daohang.index_keywords')],
            'index_description'          => ['type'=>'text', 'value'=>config('daohang.index_description')],
            'search_title'               => ['type'=>'text', 'value'=>config('daohang.search_title')],
            'search_keywords'            => ['type'=>'text', 'value'=>config('daohang.search_keywords')],
            'search_description'         => ['type'=>'text', 'value'=>config('daohang.search_description')],
            'html_hr2'                   => ['type'=> 'html','value'=>'<hr>'],
            'category_title'             => ['type'=>'text', 'value'=>config('daohang.category_title')],
            'category_keywords'          => ['type'=>'text', 'value'=>config('daohang.category_keywords')],
            'category_description'       => ['type'=>'text', 'value'=>config('daohang.category_description')],
            'tag_title'                  => ['type'=>'text', 'value'=>config('daohang.tag_title')],
            'tag_keywords'               => ['type'=>'text', 'value'=>config('daohang.tag_keywords')],
            'tag_description'            => ['type'=>'text', 'value'=>config('daohang.tag_description')],
            'html_hr3'                   => ['type'=> 'html','value'=>'<hr>'],
            'publish_title'              => ['type'=>'text', 'value'=>config('daohang.publish_title')],
            'publish_keywords'           => ['type'=>'text', 'value'=>config('daohang.publish_keywords')],
            'publish_description'        => ['type'=>'text', 'value'=>config('daohang.publish_description')],
            'fast_title'                 => ['type'=>'text', 'value'=>config('daohang.fast_title')],
            'fast_keywords'              => ['type'=>'text', 'value'=>config('daohang.fast_keywords')],
            'fast_description'           => ['type'=>'text', 'value'=>config('daohang.fast_description')],
        ];
        
        foreach($items as $key=>$value){
            $items[$key]['title']       = lang('dh_'.$key);
            if(!isset($value['placeholder'])){
                $items[$key]['placeholder'] = '';
            }
        }
        
        $this->assign('items', DcFormItems($items));
        
        return $this->fetch('daohang@seo/index');
    }
    
    public function update(){
        $status = daohangConfigSave(input('post.'));
		if( !$status ){
		    $this->error(lang('fail'));
        }
        //处理伪静态路由
        $this->rewriteRoute(input('post.'));
        //返回结果
        $this->success(lang('success'));
    }
    
    //配置伪静态
    private function rewriteRoute($post)
    {
        //批量删除路由伪静态
        \daicuo\Op::delete_all([
            'op_name'     => ['eq','site_route'],
            'op_module'   => ['eq','daohang'],
        ]);
        //批量添加路由伪静态
        $result = \daicuo\Route::save_all([
            [
                'rule'        => $post['rewrite_index'],
                'address'     => 'daohang/index/index',
                'method'      => '*',
                'op_module'   => 'daohang',
            ],
            [
                'rule'        => $post['rewrite_category'],
                'address'     => 'daohang/category/index',
                'method'      => '*',
                'op_module'   => 'daohang',
            ],
            [
                'rule'        => $post['rewrite_tag'],
                'address'     => 'daohang/tag/index',
                'method'      => '*',
                'op_module'   => 'daohang',
            ],
            [
                'rule'        => $post['rewrite_search'],
                'address'     => 'daohang/search/index',
                'method'      => '*',
                'op_module'   => 'daohang',
            ],
            [
                'rule'        => $post['rewrite_detail'],
                'address'     => 'daohang/detail/index',
                'method'      => '*',
                'op_module'   => 'daohang',
            ],
            [
                'rule'        => $post['rewrite_filter'],
                'address'     => 'daohang/filter/index',
                'method'      => '*',
                'op_module'   => 'daohang',
            ],
        ]);
        //清理全局缓存
        DcCache('route_all', null);
    }
}